<?php

/* 
    Requirement: Write a program to find the 20% of people with the largest age difference from other people in a large city.
    
    Solution:
    - Calculate the age difference between two people.
    - Find the largest age difference for each person.
    - Sort the people based on the largest age difference.
    - Find the top 20% of people with the largest age difference.
*/

function calculateAgeDifference($age1, $age2)
{
    return abs($age1 - $age2);
}

function findLargestAgeDifferences($people)
{
    $ageDifferences = [];

    foreach ($people as $i => $person1) {
        $maxAgeDifference = 0;

        foreach ($people as $j => $person2) {
            if ($i !== $j) {
                $ageDifference = calculateAgeDifference($person1['age'], $person2['age']);
                $maxAgeDifference = max($maxAgeDifference, $ageDifference);
            }
        }

        $ageDifferences[] = [
            'index' => $i,
            'ageDifference' => $maxAgeDifference
        ];
    }

    usort($ageDifferences, function ($a, $b) {
        return $b['ageDifference'] <=> $a['ageDifference'];
    });

    $top20PercentCount = ceil(count($people) * 0.2);

    $largestAgeDifferences = array_slice($ageDifferences, 0, $top20PercentCount);

    foreach ($largestAgeDifferences as $person) {
        echo "Person at index {$person['index']} has one of the largest age differences: {$person['ageDifference']} years\n";
    }
}

$people = [
    ['age' => 22],
    ['age' => 45],
    ['age' => 67],
    ['age' => 34],
    ['age' => 89],
    ['age' => 21],
    ['age' => 55],
    ['age' => 76],
    ['age' => 32],
    ['age' => 40]
];

findLargestAgeDifferences($people);