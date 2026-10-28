<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Demo account and sample Nigerian recipes, so the live demo is never empty.
     * Photos are from Wikimedia Commons; each recipe shows its author and licence.
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

        $credits = json_decode(file_get_contents(__DIR__ . '/photos/credits.json'), true);

        foreach ($this->recipes() as $slug => $r) {
            $cover = $slug . '.jpg';
            Storage::disk('public')->put('covers/' . $cover, file_get_contents(__DIR__ . '/photos/' . $cover));

            $post = new Post($r);
            $post->cover = $cover;
            $post->user_id = $chef->id;
            if (isset($credits[$slug])) {
                $c = $credits[$slug];
                $post->photo_credit = $c['author'] . ', ' . $c['license'] . ', via Wikimedia Commons';
                $post->photo_credit_url = $c['source'];
            }
            $post->save();
        }
    }

    private function recipes(): array
    {
        return [
            'zobo' => [
                'title' => 'Zobo Drink',
                'category' => 'Drinks',
                'preptime' => '45 minutes',
                'servings' => 6,
                'difficulty' => 'Easy',
                'calories' => 90,
                'description' => 'A chilled hibiscus drink with pineapple, ginger and cloves: deep red, tangy and very refreshing on a hot day.',
                'ingredients' => "2 cups dried hibiscus leaves (zobo)\n1/2 pineapple, peeled and chopped\n1 thumb of ginger, sliced\n6 cloves\n8 cups water\nSugar or honey to taste",
                'preparation' => "Rinse the zobo leaves to remove dust.\nPut the leaves, pineapple peel, ginger and cloves in a pot with the water.\nBoil for 15 minutes, then turn off the heat and let it steep for 20 minutes.\nStrain through a fine sieve.\nStir in sugar or honey while it is still warm.\nChill and serve with ice and pineapple chunks.",
            ],
            'pepper-soup' => [
                'title' => 'Goat Meat Pepper Soup',
                'category' => 'Soups',
                'preptime' => '1 hour 10 minutes',
                'servings' => 4,
                'difficulty' => 'Medium',
                'calories' => 310,
                'description' => 'A hot, light and spicy broth with tender goat meat and pepper soup spice. Perfect for cold evenings and for anyone feeling under the weather.',
                'ingredients' => "1 kg goat meat, cut into pieces\n2 tbsp pepper soup spice\n2 scotch bonnet peppers, blended\n1 onion, chopped\n2 stock cubes\nA handful of scent leaves (or basil)\nSalt to taste\n6 cups water",
                'preparation' => "Wash the goat meat and put it in a pot with the onion, stock cubes and salt.\nSteam on medium heat for 10 minutes without water so the meat releases its juices.\nAdd the water and cook for 40 minutes, until the meat is tender.\nStir in the pepper soup spice and the blended pepper.\nSimmer for 10 minutes.\nAdd the scent leaves, cook for 2 minutes and serve hot.",
            ],
            'dodo' => [
                'title' => 'Pap and Dodo',
                'category' => 'Breakfast',
                'preptime' => '20 minutes',
                'servings' => 2,
                'difficulty' => 'Easy',
                'calories' => 420,
                'description' => 'Smooth hot pap (ogi) with sweet fried plantain on the side: a soft, filling Nigerian breakfast.',
                'ingredients' => "2 ripe plantains\n1 cup pap (ogi) paste\n3 cups boiling water\nVegetable oil for frying\nSugar and milk to taste\nA pinch of salt",
                'preparation' => "Peel the plantains and cut them into slanted slices. Sprinkle with a pinch of salt.\nHeat the oil and fry the plantain for 3 minutes on each side, until golden.\nMix the pap paste with a little cold water in a bowl until smooth.\nPour in the boiling water while stirring until it thickens.\nIf it doesn't thicken, cook it on low heat for 2 minutes, stirring.\nAdd sugar and milk, and serve with the hot dodo.",
            ],
            'moi-moi' => [
                'title' => 'Moi Moi',
                'category' => 'Lunch',
                'preptime' => '1 hour 30 minutes',
                'servings' => 6,
                'difficulty' => 'Medium',
                'calories' => 280,
                'description' => 'Steamed bean pudding made from peeled beans, peppers and onions. Soft, savoury and great with rice, pap or on its own.',
                'ingredients' => "3 cups black-eyed beans, peeled\n2 red bell peppers\n1 scotch bonnet pepper\n1 onion\n1/2 cup vegetable oil\n2 stock cubes\n3 boiled eggs, sliced (optional)\nSalt to taste\n1 cup warm water",
                'preparation' => "Soak the beans for 10 minutes, then rub them to remove the skins and rinse.\nBlend the beans with the peppers, onion and warm water until very smooth.\nStir in the oil, stock cubes and salt.\nPour into greased bowls or foil, adding a slice of egg to each.\nPlace in a pot with a little water at the bottom, cover and steam for 50 minutes.\nCheck with a knife: it should come out clean. Serve warm.",
            ],
            'akara' => [
                'title' => 'Akara (Bean Cakes)',
                'category' => 'Breakfast',
                'preptime' => '40 minutes',
                'servings' => 4,
                'difficulty' => 'Medium',
                'calories' => 260,
                'description' => 'Crispy on the outside and fluffy inside: deep-fried bean fritters, the classic Saturday-morning breakfast with pap or bread.',
                'ingredients' => "2 cups black-eyed beans, peeled\n1 onion\n1 scotch bonnet pepper\n1/4 cup water\nSalt to taste\nVegetable oil for frying",
                'preparation' => "Blend the peeled beans with the onion, pepper and very little water into a thick paste.\nWhisk the paste with a wooden spoon for 5 minutes to add air. This makes it fluffy.\nAdd salt and whisk again.\nHeat the oil until hot.\nDrop spoonfuls of the paste into the oil and fry for 4 minutes on each side, until golden brown.\nDrain on paper towels and serve hot.",
            ],
            'suya' => [
                'title' => 'Beef Suya',
                'category' => 'Dinner',
                'preptime' => '40 minutes',
                'servings' => 4,
                'difficulty' => 'Easy',
                'calories' => 350,
                'description' => 'Smoky, spicy grilled beef coated in yaji spice, the way they make it at night markets across Northern Nigeria. Serve with onions and tomatoes.',
                'ingredients' => "500 g beef sirloin, thinly sliced\n4 tbsp suya spice (yaji)\n2 tbsp groundnut oil\n1 onion, sliced into rings\n2 tomatoes, sliced\nSalt to taste",
                'preparation' => "Soak wooden skewers in water for 20 minutes.\nToss the beef with oil, salt and 3 tbsp of suya spice.\nThread the beef onto the skewers.\nGrill on high heat for 4 to 5 minutes on each side.\nDust with the remaining spice and serve with onions and tomatoes.",
            ],
            'puff-puff' => [
                'title' => 'Puff-Puff',
                'category' => 'Snacks',
                'preptime' => '1 hour 30 minutes',
                'servings' => 6,
                'difficulty' => 'Easy',
                'calories' => 210,
                'description' => 'Soft, golden fried dough balls: the favourite snack at every Nigerian party.',
                'ingredients' => "3 cups plain flour\n1/2 cup sugar\n2 1/4 tsp instant yeast\n1/2 tsp nutmeg\n1/2 tsp salt\n1 1/2 cups warm water\nVegetable oil for frying",
                'preparation' => "Mix the flour, sugar, yeast, nutmeg and salt.\nAdd the warm water and mix into a smooth, sticky batter.\nCover and leave to rise for 60 minutes, until doubled.\nHeat the oil to medium.\nScoop small balls of batter into the oil and fry for 3 minutes, turning, until golden on all sides.\nDrain on paper towels and serve warm.",
            ],
            'egusi-soup' => [
                'title' => 'Egusi Soup',
                'category' => 'Soups',
                'preptime' => '1 hour',
                'servings' => 6,
                'difficulty' => 'Medium',
                'calories' => 480,
                'description' => 'A rich melon-seed soup with leafy greens and assorted meat. Serve it with pounded yam, eba or fufu.',
                'ingredients' => "2 cups ground egusi (melon seeds)\n500 g assorted meat, cooked\n1/2 cup palm oil\n2 cups chopped spinach or bitter leaf\n2 tbsp ground crayfish\n2 scotch bonnet peppers, blended\n2 stock cubes\nSalt to taste",
                'preparation' => "Heat the palm oil and fry the ground egusi for 5 minutes, stirring.\nAdd the meat stock, pepper, crayfish and stock cubes.\nAdd the cooked meat and simmer for 15 minutes.\nStir in the greens and cook for 5 minutes.\nTaste, adjust the salt and serve hot.",
            ],
            'jollof-rice' => [
                'title' => 'Nigerian Jollof Rice',
                'category' => 'Lunch',
                'preptime' => '1 hour 15 minutes',
                'servings' => 6,
                'difficulty' => 'Medium',
                'calories' => 450,
                'description' => 'The famous party rice: long-grain rice cooked in a smoky tomato and pepper sauce until every grain is red and full of flavour.',
                'ingredients' => "3 cups long-grain parboiled rice\n4 tomatoes and 3 red bell peppers, blended\n2 scotch bonnet peppers\n2 onions\n1/3 cup vegetable oil\n3 tbsp tomato paste\n2 tsp curry powder and 1 tsp thyme\n2 bay leaves\n3 cups chicken stock\nSalt and stock cubes to taste",
                'preparation' => "Fry the sliced onion in oil, then add the tomato paste and fry for 5 minutes.\nPour in the blended tomato and pepper mix and cook for 20 minutes, until the oil rises to the top.\nAdd curry, thyme, bay leaves, stock cubes and salt.\nAdd the washed rice and the stock. Stir once.\nCover tightly and cook on low heat for 30 minutes, until the rice is soft.\nTurn up the heat for the last 3 minutes for the smoky party flavour.",
            ],
        ];
    }
}
