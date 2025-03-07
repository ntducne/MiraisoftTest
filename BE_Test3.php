<?php

/* 
    There are 20 classes in the school. 
    5 classes have 35 students, 
    6 classes have 45 students, 
    10 classes have 30 students and 4 classes have 40 students. 
    The average age of all students is 20 years and 8 months.

    Requirement: Write a program to count the total number of students in each class who are older or younger than the average age by 6 months.
*/

/* 
    Solution:
    - Calculate the average age in months.
    - Loop through each class and each student in the class.
    - Generate a random age for each student.
    - Count the number of students whose age is more than 6 months older or younger than the average age.
*/

$classes = [
    "35" => 5,
    "45" => 6,
    "30" => 10,
    "40" => 4
];

$averageAgeMonths = 20 * 12 + 8;
$threshold = 6;

$olderCount = 0;
$youngerCount = 0;

foreach ($classes as $studentsPerClass => $numberOfClasses) {
    for ($i = 0; $i < $numberOfClasses; $i++) {
        for ($j = 0; $j < $studentsPerClass; $j++) {
            $studentAgeMonths = rand(216, 300);

            if ($studentAgeMonths > $averageAgeMonths + $threshold) {
                $olderCount++;
            } elseif ($studentAgeMonths < $averageAgeMonths - $threshold) {
                $youngerCount++;
            }
        }
    }
}

echo "Number of students older than the average age by 6 months: $olderCount\n";
echo "Number of students younger than the average age by 6 months: $youngerCount\n";