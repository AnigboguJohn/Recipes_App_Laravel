<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Demo account and sample recipes, so the live demo is never empty.
     * Safe to run on every start: it does nothing once the demo user exists.
     */
    public function run()
    {
        if (User::where('email', 'demo@recipes.test')->exists()) {
            return;
        }

        $chef = User::create([
            'name' => 'Demo Chef',
            'email' => 'demo@recipes.test',
            'password' => Hash::make('demo12345'),
        ]);

        foreach ($this->recipes() as $slug => $r) {
            $cover = $slug . '.svg';
            Storage::disk('public')->put('covers/' . $cover, file_get_contents(__DIR__ . '/covers/' . $cover));

            $post = new Post($r);
            $post->cover = $cover;
            $post->user_id = $chef->id;
            $post->save();
        }
    }

    private function recipes(): array
    {
        return [
            'suya' => [
                'title' => 'Beef Suya',
                'preptime' => '40 minutes',
                'description' => 'Smoky, spicy grilled beef skewers coated in yaji spice, the way they make it at night markets across Northern Nigeria.',
                'ingredients' => "500 g beef sirloin, thinly sliced\n4 tbsp suya spice (yaji)\n2 tbsp groundnut oil\n1 onion, sliced into rings\n2 tomatoes, sliced\nSalt to taste",
                'preparation' => "1. Soak wooden skewers in water for 20 minutes.\n2. Toss the beef with oil, salt and 3 tbsp of suya spice.\n3. Thread the beef onto the skewers.\n4. Grill on high heat for 4 to 5 minutes on each side.\n5. Dust with the remaining spice and serve with onions and tomatoes.",
            ],
            'puff-puff' => [
                'title' => 'Puff-Puff',
                'preptime' => '1 hour 30 minutes',
                'description' => 'Soft, golden fried dough balls: the favourite snack at every Nigerian party.',
                'ingredients' => "3 cups plain flour\n1/2 cup sugar\n2 1/4 tsp instant yeast\n1/2 tsp nutmeg\n1/2 tsp salt\n1 1/2 cups warm water\nVegetable oil for frying",
                'preparation' => "1. Mix the flour, sugar, yeast, nutmeg and salt.\n2. Add the warm water and mix into a smooth, sticky batter.\n3. Cover and leave to rise for 1 hour, until doubled.\n4. Heat the oil to medium.\n5. Scoop small balls of batter into the oil and fry until golden on all sides.\n6. Drain on paper towels and serve warm.",
            ],
            'egusi-soup' => [
                'title' => 'Egusi Soup',
                'preptime' => '1 hour',
                'description' => 'A rich melon-seed soup with leafy greens and assorted meat. Serve it with pounded yam, eba or fufu.',
                'ingredients' => "2 cups ground egusi (melon seeds)\n500 g assorted meat, cooked\n1/2 cup palm oil\n2 cups chopped spinach or bitter leaf\n2 tbsp ground crayfish\n2 scotch bonnet peppers, blended\n2 stock cubes\nSalt to taste",
                'preparation' => "1. Heat the palm oil and fry the ground egusi for 5 minutes, stirring.\n2. Add the meat stock, pepper, crayfish and stock cubes.\n3. Add the cooked meat and simmer for 15 minutes.\n4. Stir in the greens and cook for 5 more minutes.\n5. Taste, adjust the salt and serve hot.",
            ],
            'jollof-rice' => [
                'title' => 'Nigerian Jollof Rice',
                'preptime' => '1 hour 15 minutes',
                'description' => 'The famous party rice: long-grain rice cooked in a smoky tomato and pepper sauce until every grain is red and full of flavour.',
                'ingredients' => "3 cups long-grain parboiled rice\n4 tomatoes and 3 red bell peppers, blended\n2 scotch bonnet peppers\n2 onions\n1/3 cup vegetable oil\n3 tbsp tomato paste\n2 tsp curry powder and 1 tsp thyme\n2 bay leaves\n3 cups chicken stock\nSalt and stock cubes to taste",
                'preparation' => "1. Fry the sliced onion in oil, then add the tomato paste and fry for 5 minutes.\n2. Pour in the blended tomato and pepper mix. Cook until the oil rises to the top.\n3. Add curry, thyme, bay leaves, stock cubes and salt.\n4. Add the washed rice and the stock. Stir once.\n5. Cover tightly and cook on low heat for 30 minutes, until the rice is soft.\n6. Turn up the heat for the last 3 minutes for the smoky 'party' flavour.",
            ],
        ];
    }
}
