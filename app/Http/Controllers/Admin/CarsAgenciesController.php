<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CarsAgenciesRequset;
use App\Models\CarAgencies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CarsAgenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_title=__('general.carsAgencies');
        $records = CarAgencies::query()->orderByDesc('id')->paginate();

        $data = [
            'create_route'=>route('admin.carsAgencies.create')
        ];
        return view('pages.admin.carsAgencies.index', compact('data', 'page_title', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'page_title'=>__('general.create_carsAgencies'),
        ];
        return view('pages.admin.carsAgencies.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarsAgenciesRequset $request)
    {
        $image = Helpers::upload_file($request->file('image'), 'carsAgencies');
        try {
            DB::beginTransaction();
            CarAgencies::query()->create([
                'name_ar' => $request->title_ar,
                'name_en' => $request->title_en,
                'status' => $request->status,
                'image'=> $image
            ]);
            DB::commit();
            return redirect()->route('admin.carsAgencies.index')->withSuccessMessage(__('site.saved'));
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrorMessage(__('site.saved'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = CarAgencies::query()->findOrFail($id);
        $page_title = $row->name?? env('app_name');
        return view('pages.admin.carsAgencies.edit', compact('row', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarsAgenciesRequset $request, $id)
    {
        $item = CarAgencies::query()->findOrFail($id);
        $image = $item->image;
        if ($request->has('image')) {
            $file = public_path('app/public/carsAgencies/' . $item->image);
            $image = Helpers::upload_file($request->file('image'), 'carsAgencies');
            try {
                if (\File::exists($file)) {
                    unlink($file);
                }
            } catch (\Exception $e) {
            }
        }
            try {
                DB::beginTransaction();
                $item->update([
                    'name_ar'=> $request->get('title_ar'),
                    'name_en'=> $request->get('title_en'),
                    'image'=> $image,
                    'status'=> $request->get('status'),
                ]);
                DB::commit();
                return redirect()->route('admin.carsAgencies.index')->withSuccessMessage(__('site.saved'));
            }catch (\Exception $e){
                DB::rollBack();
                return redirect()->route('admin.carsAgencies.index')->withErrorMessage(__('site.error'));
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
