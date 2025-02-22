namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;


class ProductFactory extends Factory {
    protected $model = Product::class;

    public function definition() {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 1, 100),
            // Uncomment these if needed:
            // 'created_at' => now(),
            // 'updated_at' => now(),
        ];
    }
}