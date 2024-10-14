<?php
// Sample array of subjects and descriptions
$subjects = array(
  "Mathematics" => "Mathematics is the study of numbers, quantities, and shapes.",
  "English Language" => "English Language is the study of the English language, including grammar, vocabulary, and literature.",
  "Physics" => "Physics is the study of matter, energy, and the fundamental forces of nature.",
  "Chemistry" => "Chemistry is the study of the composition, structure, properties, and reactions of matter.",
  "Biology" => "Biology is the study of living organisms and their interactions with each other and the environment.",
  "Geography" => "Geography is the study of the Earth's landscapes, environments, and the relationships between people and their environments.",
  "History" => "History is the study of past events, particularly in human affairs.",
  "Agriculture" => "Agriculture is the science and practice of cultivating plants and livestock.",
  "Computer Science" => "Computer Science is the study of computers and computational systems.",
  "Accounting" => "Accounting is the systematic recording, analysis, and reporting of financial transactions.",
  "Business Studies" => "Business Studies is the study of how businesses operate, including management, marketing, and finance.",
  "Economics" => "Economics is the study of how individuals, businesses, and governments allocate resources to satisfy their needs and wants.",
  "Literature in English" => "Literature in English refers to written works, especially those considered of superior or lasting artistic merit, written in the English language.",
  "Additional Mathematics" => "Additional Mathematics is an advanced level of mathematics that includes topics such as calculus, vectors, and complex numbers.",
  "Shona" => "Shona is a Bantu language spoken by the Shona people of Zimbabwe.",
);

// Display subjects as links
foreach ($subjects as $subject => $description) {
  echo "<a class='subject' href='javascript:void(0);'>$subject</a>";
  echo "<div class='description'>$description</div>";
}
?>