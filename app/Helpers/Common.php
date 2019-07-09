<?php 

namespace App\Helpers;

class Common
{
	public static function rankscore($product)
	{
		$rating = $product->users->map(function ($user, $key) {
			return $user->rating->score;
		})->avg();
		return pow($product->users->count(), 1/3) * pow($rating, 3);
	}

	public static function avgrating($product)
	{
		$score = $product->users->map(function ($user, $key) {
        	return $user->rating->score;
        })->avg();

		$numraters = $product->users->count();

		return [$score, $numraters];
	}
}