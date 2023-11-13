<?php

class Character {
    protected $name;
    protected $marbles;
    protected $gain;
    protected $loss;

    public function __construct($name, $marbles, $gain, $loss) {
        $this->name = $name;
        $this->marbles = $marbles;
        $this->gain = $gain;
        $this->loss = $loss;
    }

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

class Hero extends Character {
    public function __construct($name, $marbles, $gain, $loss) {
        parent::__construct($name, $marbles, $gain, $loss);
    }

    public function cheat() {
        // Public method for cheating
        return rand(0, 1) == 1; // 50% de chace de gagné 
    }
}

class Enemy extends Character {
    private $age;

    public function __construct($name, $marbles, $age) {
        parent::__construct($name, $marbles, 0, 0);
        $this->age = $age;
    }

    public function getAge() {
        return $this->age;
    }
}

class Game {
    public static function generateRandomNumber($min, $max) {
        return rand($min, $max);
    }

    public static function checkEven($number) {
        return $number % 2 == 0;
    }

    public static function playGame($hero, $enemies, $difficultyLevel) {
        $totalMarbles = $hero->getMarbles();
        $rounds = $difficultyLevel;
        $currentRound = 0;
        $score = 0; // système de score

        while ($currentRound < $rounds) {
            $enemy = $enemies[self::generateRandomNumber(0, count($enemies) - 1)];
            $guess = self::generateRandomNumber(0, 1); // Randomly guess 'pair' or 'impair'
            $isPair = self::checkEven($enemy->getMarbles());

            echo "Round " . ($currentRound + 1) . " - " . $hero->getName() . " vs. " . $enemy->getName() . PHP_EOL;
            echo $hero->getName() . " has " . $totalMarbles . " marbles." . PHP_EOL;
            echo $enemy->getName() . " has " . $enemy->getMarbles() . " marbles." . PHP_EOL;

            if ($guess == $isPair) {
                
                $totalMarbles += $enemy->getMarbles() + $hero->getGain();
                echo "You guessed correctly and won the round!" . PHP_EOL;
                $score += 1; // Augmenter le score en cas de victoire
            } else {
                // You lose
                $totalMarbles -= $enemy->getMarbles() - $hero->getLoss();
                echo "Vous vous êtes trompé et vous avez perdu la manche." . PHP_EOL;
            }

            if ($totalMarbles <= 0) {
                echo "Game over. You lost all your marbles." . PHP_EOL;
                return;
            }

            $currentRound++;
        }

        if ($totalMarbles >= 1) {
            echo "Félicitations, vous avez remporté le jeu et gagné 45,6 milliards de wons sud-coréens !" . PHP_EOL;
            echo "Votre score est de: " . $score . " out of " . $rounds . " rounds." . PHP_EOL;
        } else {
            echo "Vous n'avez pas pu garder au moins une bille. La partie est terminée." . PHP_EOL;
        }
    }
}

// Sample usage
$characters = [
    new Hero("Seong Gi-hun", 15, 1, 2),
    new Hero("Kang Sae-byeok", 25, 2, 1),
    new Hero("Cho Sang-woo", 35, 3, 0)
];

$enemies = [];

for ($i = 1; $i <= 20; $i++) {
    $enemies[] = new Enemy("Opponent" . $i, rand(1, 20), rand(1, 99));
}

$difficultyLevel = Game::generateRandomNumber(1, 3);

Game::playGame($characters[Game::generateRandomNumber(0, count($characters) - 1)], $enemies, $difficultyLevel);
