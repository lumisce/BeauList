<?php 

namespace App\Helpers;

class Common
{
	public static function rankscore($product)
	{
		$rating = $product->ratedBy->map(function ($user, $key) {
			return $user->rating->score;
		})->avg();

		return pow($product->ratedBy->count(), 1/3) * pow($rating, 3);
	}

	public static function avgrating($product)
	{
		$score = $product->ratedBy->map(function ($user, $key) {
        	return $user->rating->score;
        })->avg();

		$numraters = $product->ratedBy->count();
		return [$score, $numraters];
	}
}