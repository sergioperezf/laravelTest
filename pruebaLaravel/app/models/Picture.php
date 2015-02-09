<?php


class Picture extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pictures';
        
        public function scopeOfUser($query, $userId){
            return $query->where('user_id', '=', $userId);
        }

}
