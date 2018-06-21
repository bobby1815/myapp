<?php
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
$factory->define(App\User::class, function (Faker\Generator $faker) {
	$activated = $faker->randomElement([0, 1]);
	return [
		'name' => $faker->name,
		'email' => $faker->safeEmail,
		'password' => bcrypt('password'),
		'remember_token' => str_random(10),
		'activated' => $activated,
		'confirm_code' => $activated ? str_random(60) : null,
	];
});
$factory->define(App\Article::class, function (Faker\Generator $faker) {
	$date = $faker->dateTimeThisMonth;
	return [
		'title' => $faker->sentence(),
		'content' => $faker->paragraph(),
		'created_at' => $date,
		'updated_at' => $date,
	];
});


$factory->define(App\Attachment::class, function(Faker\Generator $faker){

	return [
		'filename' => sprintf("%s.%s",str_random(),$faker->randomElement(['jpg','png','zip','tar']))
	];
});


$factory->define(App\Comment::class, function(Faker\Generator $faker) {
	$articleIds = App\Article::pluck('id')->toArray();
	$userIds    = App\User::pluck('id')->toArray();

	return [
		'content'           => $faker->paragraph,
		'commentable_type'  => App\Article::class,
		'commentable_id'    => function() use ($faker, $articleIds){
			return $faker->randomElement($articleIds);
		},
		'user_id'           => function() use ($faker, $userIds){
			return $faker->randomElement($userIds);
		}
	];

});