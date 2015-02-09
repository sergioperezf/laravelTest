<?php

class Picture extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pictures';

    public function scopeOfUser($query, $userId) {
        return $query->where('user_id', '=', $userId);
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($picture) {
            $users = User::where('picture_id', '=', $picture->id)->get();
            foreach ($users as $user) {
                $user->picture_id = null;
                $user->save();
            }
        });
    }

}
