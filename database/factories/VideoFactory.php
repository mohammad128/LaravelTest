<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

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
        $videos = ['uploads/videos/1.mp4', 'uploads/videos/2.mp4', 'uploads/videos/3.mp4'];
        return [
            'title'=>$this->faker->text(50),
            'user_id'=> $users[rand(0,$user_count)]->id,
            'description'=>$this->faker->paragraph(rand(3,5)),
            'video'=>$videos[rand(0,2)],
            'status'=> $status[rand(0,1)]
        ];
    }
}
