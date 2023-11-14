<?php
//  class représent les personnages du jeu. La classe Character 
// est la classe de base qui contient les propriétés communes à tous les personnages, 
//  telles que le nom, le nombre de billes, le gain et la perte.
class Character {
    protected $name;
    protected $marbles;
    protected $gain;
    protected $loss;

    // cette fonction constructrice initialise les propriétés d'un 
    // objet avec les valeurs fournies pour le nom, les billes, le gain et la perte.
    public function __construct($name, $marbles, $gain, $loss) {
        $this->name = $name;
        $this->marbles = $marbles;
        $this->gain = $gain;
        $this->loss = $loss;
    }

    // Ces fonctions retournent respectivement le nom, le nombre de billes, le gain et la perte d'un objet.
    public function getName() {
        return $this->name;
    }

    public function getMarbles() {
        return $this->marbles;
    }

    public function getGain() {
        return $this->gain;
    }

    public function getLoss() {
        return $this->loss;
    }
}
// la classe Character et utilise le constructeur de la classe parent (Character) 
// pour initialiser les propriétés de l'objet Hero avec les valeurs fournies.
class Hero extends Character {
    public function __construct($name, $marbles, $gain, $loss) {
        parent::__construct($name, $marbles, $gain, $loss);
    }
    // fonction retourne vrai avec une probabilité de 50%, simulant une tricherie.
    public function cheat() {
        return rand(0, 1) == 1; 
    }
}
// class Enemy étend la class Character et possède une propriété privée supplémentaire appelée $age.
class Enemy extends Character {
    private $age;

    // constructeur initialise un objet de la classe Enemy avec un nom, un nombre de billes, et un âge, en utilisant le constructeur de la classe parent (Character) pour les propriétés 
    // communes et en attribuant la valeur de l'âge à la propriété privée $age.
    public function __construct($name, $marbles, $age) {
        parent::__construct($name, $marbles, 0, 0);
        $this->age = $age;
    }

    // fonction retourne l'âge d'un objet Enemy.
    public function getAge() {
        return $this->age;
    }
}
// possède une méthode statique, generateRandomNumber, 
// qui génère et retourne un nombre aléatoire dans la plage spécifiée.
class Game {
    public static function generateRandomNumber($min, $max) {
        return rand($min, $max);
    }
    // méthode statique checkEven vérifie si un nombre 
    // donné est pair, et retourne vrai s'il l'est, sinon faux.
    public static function checkEven($number) {
        return $number % 2 == 0;
    }

    // méthode statique playGame initialise les variables pour 
    // le nombre total de billes du héros, le nombre de 
    // rounds basé sur le niveau de difficulté, le round actuel, et le score du jeu.
    public static function playGame($hero, $enemies, $difficultyLevel) {
        $totalMarbles = $hero->getMarbles();
        $rounds = $difficultyLevel;
        $currentRound = 0;
        $score = 0; 
        // cette boucle while, à chaque itération, un ennemi est sélectionné aléatoirement 
        // parmi la liste d'ennemis, une supposition est générée aléatoirement, et la variable $isPair 
        // est évaluée en fonction de la parité du nombre de billes de l'ennemi.
        while ($currentRound < $rounds) {
            $enemy = $enemies[self::generateRandomNumber(0, count($enemies) - 1)];
            $guess = self::generateRandomNumber(0, 1); 
            $isPair = self::checkEven($enemy->getMarbles());

            // Ces lignes d'écho affichent le numéro du round, les noms et le nombre de billes du héros 
            // et de l'ennemi à chaque itération du jeu.
            echo "Round " . ($currentRound + 1) . " - " . $hero->getName() . " vs. " . $enemy->getName() . PHP_EOL;
            echo $hero->getName() . " has " . $totalMarbles . " marbles." . PHP_EOL;
            echo $enemy->getName() . " has " . $enemy->getMarbles() . " marbles." . PHP_EOL;


// Cette condition vérifie si la supposition du joueur est correcte par rapport à la parité du nombre de billes de l'ennemi, puis ajuste le nombre total de billes du héros, affiche 
// un message de victoire pour le round et incrémente le score en cas de succès.
            if ($guess == $isPair) {
                
                $totalMarbles += $enemy->getMarbles() + $hero->getGain();
                echo "You guessed correctly and won the round!" . PHP_EOL;
                $score += 1; 
            } else {
                // ajuste le nombre total de billes du héros en soustrayant le nombre de billes de l'ennemi 
                // et la perte du héros, puis affiche un message de défaite pour le tour.
                $totalMarbles -= $enemy->getMarbles() - $hero->getLoss();
                echo "Vous vous êtes trompé et vous avez perdu la manche." . PHP_EOL;
            }

            // condition vérifie si le nombre total de billes du héros est inférieur ou égal à zéro, 
            // affiche un message de fin de jeu indiquant la perte de toutes les billes, et met fin à la partie.
            if ($totalMarbles <= 0) {
                echo "Fin de la partie. Vous avez perdu toutes vos billes." . PHP_EOL;
                return;
            }

            $currentRound++;
        }
        // condition vérifie si le nombre total de billes du héros est supérieur ou égal à 1. Si c'est le cas, elle affiche 
        // un message de félicitations pour avoir remporté le jeu avec un gain imaginaire en wons sud-coréens et affiche le score du joueur.
        //  Sinon, elle affiche un message indiquant que le joueur 
        // n'a pas pu conserver au moins une bille, mettant fin à la partie.
        if ($totalMarbles >= 1) {
            echo "Félicitations, vous avez remporté le jeu et gagné 45,6 milliards de wons sud-coréens !" . PHP_EOL;
            echo "Votre score est de: " . $score . " out of " . $rounds . " rounds." . PHP_EOL;
        } else {
            echo "Vous n'avez pas pu garder au moins une bille. La partie est terminée." . PHP_EOL;
        }
    }
}

// crée un tableau de personnages avec trois instances de la classe Hero, chacune représentant un personnage du jeu avec un nom,
//  un nombre initial de billes, un gain et une perte spécifiques.
$characters = [
    new Hero("Seong Gi-hun", 15, 1, 2),
    new Hero("Kang Sae-byeok", 25, 2, 1),
    new Hero("Cho Sang-woo", 35, 3, 0)
];

// crée un tableau vide destiné à stocker des ennemis (instances de la classe Enemy) dans un contexte de jeu.

$enemies = [];

// boucle for crée un tableau d'ennemis avec 20 instances de la classe Enemy, 
// chaque ennemi étant nommé "Opponent" suivi du numéro de l'itération, et ayant un nombre de billes 
// et un âge générés aléatoirement dans des plages spécifiées.

for ($i = 1; $i <= 20; $i++) {
    $enemies[] = new Enemy("Opponent" . $i, rand(1, 20), rand(1, 99));
}

// ligne génère un niveau de difficulté aléatoire entre 1 et 3, puis lance une partie en utilisant la méthode statique playGame
$difficultyLevel = Game::generateRandomNumber(1, 3);

Game::playGame($characters[Game::generateRandomNumber(0, count($characters) - 1)], $enemies, $difficultyLevel);
