<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKnowledgeBaseRequest;
use App\Http\Requests\UpdateKnowledgeBaseRequest;
use App\Models\KnowledgeBase;

class KnowledgeBaseController extends Controller
{
    public function index()
    {
        $data = KnowledgeBase::orderBy('category')
            ->orderBy('priority', 'desc')
            ->get();
            
        return view('admin.knowledge-base.index', compact('data'));
    }

    public function create()
    {
        return view('admin.knowledge-base.create');
    }

    public function store(StoreKnowledgeBaseRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : true;
        $validated['priority'] = $validated['priority'] ?? 0;

        KnowledgeBase::create($validated);

        return redirect()->route('admin.knowledge-base.index')
            ->with('success', 'Data knowledge base berhasil ditambahkan!');
    }

    public function edit(KnowledgeBase $knowledgeBase)
    {
        return view('admin.knowledge-base.edit', compact('knowledgeBase'));
    }

    public function update(UpdateKnowledgeBaseRequest $request, KnowledgeBase $knowledgeBase)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : true;
        $validated['priority'] = $validated['priority'] ?? 0;

        $knowledgeBase->update($validated);

        return redirect()->route('admin.knowledge-base.index')
            ->with('success', 'Data knowledge base berhasil diperbarui!');
    }

    public function destroy(KnowledgeBase $knowledgeBase)
    {
        $knowledgeBase->delete();

        return redirect()->route('admin.knowledge-base.index')
            ->with('success', 'Data knowledge base berhasil dihapus!');
    }
}