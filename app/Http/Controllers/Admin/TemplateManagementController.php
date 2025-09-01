<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateManagementController extends Controller
{
    public function index()
    {
        $template = Template::latest()->paginate(10);
        return view('admin.template.index', compact('template'));
    }

    public function create()
    {
        return view('admin.template.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'file' => 'required|mimes:pdf,docx|max:2048',
            'aturan_format' => 'nullable|string',
        ]);

        $path = $request->file('file')->store('template', 'public');

        Template::create([
            'nama_template' => $request->nama_template,
            'prodi' => $request->prodi,
            'tipe_file' => $request->file('file')->extension(),
            'file_path' => $path,
            'aturan_format' => $request->aturan_format,
        ]);

        return redirect()->route('admin.template.index')->with('success', 'Template berhasil ditambahkan');
    }

    public function edit(Template $template)
    {
        return view('admin.template.edit', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'file' => 'nullable|mimes:pdf,docx|max:2048',
            'aturan_format' => 'nullable|string',
        ]);

        $data = $request->only(['nama_template', 'prodi', 'aturan_format']);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($template->file_path);
            $data['file_path'] = $request->file('file')->store('template', 'public');
            $data['tipe_file'] = $request->file('file')->extension();
        }

        $template->update($data);

        return redirect()->route('admin.template.index')->with('success', 'Template berhasil diperbarui');
    }

    public function destroy(Template $template)
    {
        Storage::disk('public')->delete($template->file_path);
        $template->delete();

        return redirect()->route('admin.template.index')->with('success', 'Template berhasil dihapus');
    }
}
