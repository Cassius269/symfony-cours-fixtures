<?php

namespace APP\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Collecter les noms des ingrédients dans un tableau
        $ingredients = ['sucre', 'farine', 'oeuf', 'sel', 'poivre', 'chocolat', 'tomate', 'courgette', 'crème'];

        // Boucler tous les élements du tableau et persister chacun des élements
        foreach ($ingredients as $ingredient) {
            $ingredientToSave = new Ingredient();

            $ingredientToSave->setName($ingredient)
                ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($ingredientToSave);
        }

        // Envoyer en une seule fois en base de données les ingrédients précédemment persistées
        $manager->flush();
    }
}
