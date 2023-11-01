<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySectionRequest;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Section;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SectionController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::all();

        return view('admin.sections.index', compact('sections'));
    }

    public function create()
    {
        abort_if(Gate::denies('section_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sections.create');
    }

    public function store(StoreSectionRequest $request)
    {
        $section = Section::create($request->all());

        return redirect()->route('admin.sections.index')->with('created', 'New Section Added.');
    }

    public function edit(Section $section)
    {
        abort_if(Gate::denies('section_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sections.edit', compact('section'));
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        $section->update($request->all());

        return redirect()->route('admin.sections.index')->with('updated', 'Section Updated.');
    }

    public function destroy(Section $section)
    {
        abort_if(Gate::denies('section_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $section->delete();

        return back()->with('deleted', 'Section Deleted.');
    }

    public function massDestroy(MassDestroySectionRequest $request)
    {
        $sections = Section::find(request('ids'));

        foreach ($sections as $section) {
            $section->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
