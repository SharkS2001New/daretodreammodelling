<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetaBackup;

class MetaController extends Controller
{
    protected $filePath;

    public function __construct()
    {
        $this->filePath = public_path('meta.json');
    
        $latestBackup = MetaBackup::latest()->first();
    
        if ($latestBackup && is_array($latestBackup->data)) {
            // Always recreate meta.json from DB backup
            file_put_contents($this->filePath, json_encode($latestBackup->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }    

    public function index()
    {
        $metas = json_decode(file_get_contents($this->filePath), true);

        return view('seo-metas.index', compact('metas'));
    }

    public function create()
    {
        return view('seo-metas.create');
    }

    public function edit($page)
    {
        $metas = json_decode(file_get_contents($this->filePath), true);
        
        $meta = $metas[$page] ?? ['title' => '', 'description' => '', 'keywords' => ''];

        return view('seo-metas.edit', [
            'title' => $meta['title'] ?? '',
            'description' => $meta['description'] ?? '',
            'keywords' => $meta['keywords'] ?? '',
            'page' => $page,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page' => 'required|string',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
        ]);

        $file = public_path('meta.json');
        $metas = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        $metas[$data['page']] = [
            'title' => $data['title'],
            'description' => $data['description'],
            'keywords' => $data['keywords'],
        ];

        file_put_contents($file, json_encode($metas, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->backupToDatabase($metas);

        return redirect()->route('seo-metas.index', $data['page'])->with('success', 'Meta added successfully.');
    }

    public function update(Request $request, $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'keywords' => 'nullable|string|max:1000'
        ]);

        $metas = json_decode(file_get_contents($this->filePath), true);

        $metas[$page] = [
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords
        ];

        file_put_contents($this->filePath, json_encode($metas, JSON_PRETTY_PRINT));
        $this->backupToDatabase($metas);

        return redirect()->route('seo-metas.index')->with('success', 'Meta updated for ' . $page);
    }

    public function destroy($page)
    {
        $metas = json_decode(file_get_contents($this->filePath), true);

        if (isset($metas[$page])) {
            unset($metas[$page]);
            file_put_contents($this->filePath, json_encode($metas, JSON_PRETTY_PRINT));
            $this->backupToDatabase($metas);
        }

        return redirect()->route('seo-metas.index')->with('success', 'Meta deleted for ' . $page);
    }

    protected function backupToDatabase(array $metas)
    {
        MetaBackup::create(['data' => $metas]);
    }
}
