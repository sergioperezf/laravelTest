<?php

class PictureController extends Controller {

    /*
     * upload picture. This function is meant to be calles as a post from the 
     * view, using jQuery. The results of this function will update via ajax the
     * edit view.
     */
    public function upload() {
        $return = [];
        //only authenticated users can upload pictures
        if (Auth::check()) {
            try {
                $file = Input::file('file');
                $validator = $this->getFileValidator();
                if (!$validator->passes()) {
                    //this message will be shown to the user in the view
                    throw new Exception('File must be an image');
                }
                $assetPath = '/uploads/images';
                $uploadPath = public_path($assetPath);
                //the name of the picture is unique
                $newName = Auth::user()->username . '_' . time() . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                //save the file
                $file->move($uploadPath, $newName);
                $path = $assetPath . '/' . $newName;
                //create de model
                $picture = new Picture();
                $picture->path = $path;
                $picture->user_id = Auth::user()->id;
                $picture->save();
                //retrieve list of user's pictures from db
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
        //return json data
        return json_encode($return);
    }

    /*
     * file validator
     */
    protected function getFileValidator() {
        return Validator::make(Input::all(), [
                    'file' => 'image',
        ]);
    }

    /*
     * delete files.
     */
    public function delete() {
        $return = [];
        if (Auth::check()) {
            //this method deletes various pictures
            foreach (Input::get('picture_id') as $id) {
                $picture = Picture::find($id);
                //only can delete the user's pictures
                if ($picture && $picture->user_id == Auth::user()->id) {
                    $picture->delete();
                }
            }
            //get list of pictures from database
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
