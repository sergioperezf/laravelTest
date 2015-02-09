<?php

class PictureController extends Controller {

    public function upload() {
        $return = [];
        if (Auth::check()) {
            try {
                $file = Input::file('file');
                $validator = $this->getFileValidator();
                if (!$validator->passes()) {
                    throw new Exception('File must be an image');
                }
                $assetPath = '/uploads/images';
                $uploadPath = public_path($assetPath);
                $newName = Auth::user()->username . '_' . time() . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                $file->move($uploadPath, $newName);
                $path = $assetPath . '/' . $newName;
                $picture = new Picture();
                $picture->path = $path;
                $picture->user_id = Auth::user()->id;
                $picture->save();
                $pictures = Picture::ofUser(Auth::user()->id)->get();
                foreach ($pictures as $picture) {
                    $return[$picture->id] = $picture->path;
                }
                $return['status'] = 'OK';
            } catch (\Exception $e) {
                $return['status'] = 'FAILED';
                $return['message'] = $e->getMessage();
            }
        }
        return json_encode($return);
    }

    protected function getFileValidator() {
        return Validator::make(Input::all(), [
                    'file' => 'image',
        ]);
    }

    public function delete() {
        $return = [];
        if (Auth::check()) {
            foreach (Input::get('picture_id') as $id) {
                $picture = Picture::find($id);
                if ($picture && $picture->user_id == Auth::user()->id) {
                    $picture->delete();
                }
            }
            $pictures = Picture::ofUser(Auth::user()->id)->get();
            foreach ($pictures as $picture) {
                $return[$picture->id] = $picture->path;
            }
            $return['status'] = 'OK';
        }
        return json_encode($return);
    }

    protected function isPostRequest() {
        return Input::server("REQUEST_METHOD") == "POST";
    }

}
