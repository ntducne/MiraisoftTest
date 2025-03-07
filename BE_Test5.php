<?php
/* 
    A group of people are walking in the area as shown in the illustration
    The red line is the row of red flags
    The yellow line is the row of yellow flags
    The green line is the row of green flags
    The blue line is the row of blue flags
    The person walking can tell how far away his or her position is from the two nearest rows of flags on either side

    Requirement:: Write a program to find the 10% of people who are furthest away from other people

    Solution:
    - Calculate the distance between two people.
    - Find the average distance for each person.
    - Sort the people based on the average distance.
    - Find the top 10% of people with the largest average distance.
*/
class Person {
    public $id;
    public $x;
    public $y;
    public $avgDistance;

    public function __construct($id, $x, $y) {
        $this->id = $id;
        $this->x = $x;
        $this->y = $y;
        $this->avgDistance = 0;
    }
}
function calculateDistance(Person $person1, Person $person2) {
    return sqrt(pow($person1->x - $person2->x, 2) + pow($person1->y - $person2->y, 2));
}
function findFurthestPeople($people) {
    $numPeople = count($people);
    if ($numPeople < 2) {
        return $people;
    }
    foreach ($people as $person1) {
        $totalDistance = 0;
        $count = 0;
        foreach ($people as $person2) {
            if ($person1->id !== $person2->id) {
                $totalDistance += calculateDistance($person1, $person2);
                $count++;
            }
        }
        $person1->avgDistance = $totalDistance / $count;
    }
    usort($people, function($a, $b) {
        return $b->avgDistance <=> $a->avgDistance;
    });
    $top10PercentCount = max(1, (int)($numPeople * 0.1));
    return array_slice($people, 0, $top10PercentCount);
}

$numPeople = 20; // Example: 20 people
$people = [];

for ($i = 0; $i < $numPeople; $i++) {
    $x = rand(-1000, 1000) / 100;
    $y = rand(-1000, 1000) / 100;
    $people[] = new Person($i, $x, $y);
}
$furthestPeople = findFurthestPeople($people);
echo "Total number of people: $numPeople\n";
echo "Top 10% of people furthest from others:\n";
foreach ($furthestPeople as $person) {
    echo "Person {$person->id}: Position ({$person->x}, {$person->y}), Average Distance: {$person->avgDistance}\n";
}