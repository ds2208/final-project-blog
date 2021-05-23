<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Validation\Rule;

class AdsController extends Controller {

    public function index(Request $request) {

        $ads = Ad::query()
                ->orderBy('priority')
                ->get();

        return view('admin.ads.index', [
            'ads' => $ads,
        ]);
    }

    public function add(Request $request) {
        return view('admin.ads.add');
    }

    public function insert(Request $request) {
        
        $formData = $request->validate([
            'title' => ['required', 'string', 'min:2', 'unique:ads,title'],
            'button_title' => ['required', 'string', 'min:2', 'max:20'],
            'url' => ['required', 'url', 'min:10', 'max:255'],
            'photo' => ['nullable', 'file', 'image', 'max:65000']
        ]);

        $adWithHighestPriority = Ad::query()
                ->orderBy('priority', 'desc')
                ->first();
        
        $newAd = new Ad();

        if ($adWithHighestPriority) {
            $newAd->priority = $adWithHighestPriority->priority + 1;
        } else {
            $newAd->priority = 1;
        }
        
        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $photoFileName = $newAd->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(public_path('/storage/ads/'), $photoFileName);

            $newAd->photo = $photoFileName;
            $newAd->save();

            \Image::make(public_path('/storage/ads/' . $newAd->photo))
                    ->fit(1280, 868)
                    ->save();
        }      
        
        $newAd->fill($formData)->save();

        session()->flash('system_message', 'Ad has been added!');
        return redirect()->route('admin.ads.index');
    }

    public function edit(Request $request, Ad $ad) {
        return view('admin.ads.edit', [
            'ad' => $ad
        ]);
    }

    public function update(Request $request, Ad $ad) {
        
        $formData = $request->validate([
            'title' => ['required', 'string', 'max:50', Rule::unique('ads')->ignore($ad->id)],
            'button_title' => ['required', 'string', 'min:2', 'max:20'],
            'url' => ['required', 'url', 'min:10', 'max:255'],
            'photo' => ['nullable', 'file', 'image', 'max:65000']
        ]);

        $ad->fill($formData)->save();
        
        if ($request->hasFile('photo')) {
            $ad->deletePhoto();

            $photoFile = $request->file('photo');
            $photoFileName = $ad->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(public_path('/storage/ads/'), $photoFileName);

            $ad->photo = $photoFileName;
            $ad->save();

            \Image::make(public_path('/storage/ads/' . $ad->photo))
                    ->fit(1280, 868)
                    ->save();
        }

        session()->flash('system_message', 'Ad has been edited!');
        return redirect()->route('admin.ads.index');
    }

    public function delete(Request $request) {

        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:ads,id']
        ]);

        $ad = Ad::findOrFail($formData['id']);
        $ad->delete();

        Ad::query()
                ->where('priority', '>', $ad->priority)
                ->decrement('priority');

        session()->flash('system_message', 'Ad has been deleted!');
        return redirect()->route('admin.ads.index');
    }

    public function changePriorities(Request $request) {
        $formData = $request->validate([
            'priorities' => ['required', 'string']
        ]);

        $priorities = explode(',', $formData['priorities']); //change string to array

        foreach ($priorities as $key => $id) {
            $ad = Ad::findOrFail($id);
            $ad->priority = $key + 1;
            $ad->save();
        }

        session()->flash('system_message', 'Ads have been ordered!');
        return redirect()->route('admin.ads.index');
    }

    
    public function changeIndex(Request $request) {
        
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:ads,id']
        ]);
        
        $ad = Ad::findOrFail($formData['id']);
        $ad->changeIndex()->save();

        session()->flash(
                'system_message',
                __('Featured of :ad has been changed!', ['ad' => $ad->title])
                );
        return redirect()->route('admin.ads.index');
    }
    
    public function deletePhoto(Request $request, Ad $ad){
        
        $ad->deletePhoto();
        $ad->photo = null;
        $ad->save();
        
        return response()->json([
            "system_message" => "Photo has been deleted",
            "photo" => $ad->getPhotoUrl()
        ]);
    }

}
