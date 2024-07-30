import { computeEcoIndex, getEcoIndexGrade } from "ecoindex";

((Drupal, drupalSettings) => {
  console.log("passe ici ?");
  const messages = new Drupal.Message();
  messages.clear();

  // Number of elements.
  const numberOfElements = document.getElementsByTagName("*:not(#toolbar-administration, #node-preview-form-select)").length;

  // Number of requests.
  const resources = performance.getEntriesByType("resource");
  const numberOfRequests = resources.length;

  // Total size (KB).
  const totalSizeKB = resources.reduce((total, resource) => total + resource.transferSize, 0) / 1024;

  // Get EcoIndex score.
  const ecoIndex = Number(computeEcoIndex(numberOfElements, numberOfRequests, totalSizeKB));
  const score = Math.round(ecoIndex);

  // Get EcoIndex grade.
  const grade = getEcoIndexGrade(ecoIndex);

  // Set localstorage.
  // localStorage.setItem(key, score);

  messages.add("EcoIndex " + score);

  // const spanScore = document.querySelector(".ecoindex-score");
  // if (spanScore) spanScore.textContent = "EcoIndex " + score;

  // const spanGrade = document.querySelector(".ecoindex-grade");
  // if (spanGrade) {
  //   spanGrade.textContent = "Grade " + grade;

  //   const gradeColors = {
  //     A: "#2e9b43",
  //     B: "#34bc6e",
  //     C: "#cadd00",
  //     D: "#f7ed00",
  //     E: "#ffce00",
  //     F: "#fb9929",
  //   };
  //   spanGrade.style.background = gradeColors[grade] || "#f01c16";
  // }
})(Drupal, drupalSettings);
