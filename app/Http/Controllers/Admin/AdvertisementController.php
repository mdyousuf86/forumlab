<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Advertisement';
        $ads       = Advertisement::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.ads.index', compact('pageTitle', 'ads'));
    }

    public function store(Request $request, $id = 0)
    {

        $imageValidate = $id ? 'nullable' : 'required';

        if ($request->type == 2) {
            $scriptValidate = 'required';
            $imageValidate  = 'nullable';
        } else {
            $imageValidate  = 'required';
            $scriptValidate = 'nullable';
        }


        $request->validate([
            'type'   => 'required|integer|in:1,2',
            'link'   => 'nullable|url',
            'image'  => [$imageValidate, new FileTypeValidate(['jpg', 'jpeg', 'png', 'gif'])],
            'script' => "$scriptValidate|string",
        ]);

        if ($id) {
            $advertise    = Advertisement::findOrFail($id);
            $notification = 'Advertise updated successfully';
        } else {
            $advertise    = new Advertisement();
            $notification = 'Advertise added successfully';
        }

        if ($request->hasFile('image')) {
            try {
                $filename = fileUploader($request->image, getFilePath('ads'), getFileSize('ads'), @$advertise->content->image);
            } catch (\Exception $e) {
                $notify[] = ['error', 'Image could not be uploaded'];
                return back()->withNotify($notify);
            }
        }
        $advertise->type = $request->type;
        $data            = [
            'image'  => $filename ?? @$advertise->content->image,
            'link'   => $request->type == 1 ? $request->link : null,
            'script' => $request->type == 2 ? $request->script : null,
        ];
        $advertise->content = $data;
        $advertise->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Advertisement::changeStatus($id);
    }

    public function delete($id)
    {
        $ads = Advertisement::findOrFail($id);
        if (@$ads->content->image) {
            fileManager()->removeFile(getFilePath('ads') . '/' . @$ads->content->image);
        }
        $ads->delete();
        $notify[] = ['success', 'Advertise deleted successfully'];
        return back()->withNotify($notify);
    }
}
