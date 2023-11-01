<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDependentRequest;
use App\Http\Requests\StoreDependentRequest;
use App\Http\Requests\UpdateDependentRequest;
use App\Models\Dependent;
use App\Models\Member;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DependentController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request, Member $member)
    {
        // dd($member);
        abort_if(Gate::denies('dependent_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Dependent::query()->select(sprintf('%s.*', (new Dependent)->table))->where('member_id', '=', $member->id);
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'dependent_show';
                $editGate      = 'dependent_edit';
                $deleteGate    = 'dependent_delete';
                $crudRoutePart = 'dependents';

                return view('partials.datatableDependentActions', compact(
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->editColumn('relation', function ($row) {
                return $row->relation ? Dependent::RELATION_SELECT[$row->relation] : '';
            });
            $table->editColumn('occupation', function ($row) {
                return $row->occupation ? $row->occupation : '';
            });
            $table->editColumn('nationality', function ($row) {
                return $row->nationality ? $row->nationality : '';
            });
            $table->editColumn('golf_hcap', function ($row) {
                return $row->golf_hcap ? $row->golf_hcap : '';
            });
            $table->editColumn('allow_credit', function ($row) {
                return $row->allow_credit ? Dependent::ALLOW_CREDIT_SELECT[$row->allow_credit] : '';
            });
            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'photo']);

            return $table->make(true);
        }

        return view('admin.dependents.index');
    }

    public function create(Member $member)
    {

        abort_if(Gate::denies('dependent_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dependents.create', array('member' => $member));
    }


    public function store(StoreDependentRequest $request, Member $member)
    {

        $dependent = Dependent::create(array_merge($request->all(), ['member_id' => $member->id]));

        if ($request->input('photo', false)) {
            $dependent->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $dependent->id]);
        }

        return redirect()->route('admin.members.index');
    }

    public function edit(Dependent $dependent)
    {
        abort_if(Gate::denies('dependent_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dependents.edit', compact('dependent'));
    }

    public function update(UpdateDependentRequest $request, Dependent $dependent)
    {
        // dd();
        $dependent->update($request->all());

        if ($request->input('photo', false)) {
            if (! $dependent->photo || $request->input('photo') !== $dependent->photo->file_name) {
                if ($dependent->photo) {
                    $dependent->photo->delete();
                }
                $dependent->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($dependent->photo) {
            $dependent->photo->delete();
        }

        return redirect()->route('admin.members.index');
    }

    public function show(Dependent $dependent,Member $member)
    {
        abort_if(Gate::denies('dependent_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dependents.show', compact('dependent'));
    }

    public function destroy(Dependent $dependent)
    {
        abort_if(Gate::denies('dependent_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dependent->delete();

        return back();
    }

    public function massDestroy(MassDestroyDependentRequest $request)
    {
        $dependents = Dependent::find(request('ids'));

        foreach ($dependents as $dependent) {
            $dependent->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('dependent_create') && Gate::denies('dependent_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Dependent();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
