<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();
        $user_count = count($users) - 1;
        $status = ['draft','published'];
        return [
            'title'=>$this->faker->text(50),
            'user_id'=> $users[rand(0,$user_count)]->id,
            'content'=>$this->faker->paragraph(rand(3,5)),
            'status'=> $status[rand(0,1)]
        ];
    }
}
