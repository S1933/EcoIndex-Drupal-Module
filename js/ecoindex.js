import { computeEcoIndex, getEcoIndexGrade } from "ecoindex";

((Drupal, drupalSettings) => {
  const messages = new Drupal.Message();
  messages.clear();

  // Get localstorage key.
  const key = drupalSettings.ecoindex.key;

  if (document.getElementById("edit-field-ecoindex-0-value")) {
    const score = localStorage.getItem(key);
    const fieldEcoIndex = document.getElementById(
      "edit-field-ecoindex-0-value"
    );
    const current = fieldEcoIndex.value;
    fieldEcoIndex.value = score;

    if (Math.abs(current - score) > 5) {
      messages.add(
        "EcoIndex changed, submit this form to save the new EcoIndex.",
        {
          type: "warning",
        }
      );
    }
  }

  // Number of elements.
  const numberOfElements = document.getElementsByTagName(
    "*:not(#toolbar-administration)"
  ).length;

  // Number of requests.
  const resources = performance.getEntriesByType("resource");
  const numberOfRequests = resources.length;

  // Total size (KB).
  const totalSizeKB =
    resources.reduce((total, resource) => total + resource.transferSize, 0) /
    1024;

  // Get EcoIndex score.
  const ecoIndex = Number(
    computeEcoIndex(numberOfElements, numberOfRequests, totalSizeKB)
  );
  const score = Math.round(ecoIndex);

  // Get EcoIndex grade.
  const grade = getEcoIndexGrade(ecoIndex);

  // Set localstorage.
  localStorage.setItem(key, score);

  const spanScore = document.querySelector(".ecoindex-score");
  if (spanScore) spanScore.textContent = "EcoIndex " + score;

  const spanGrade = document.querySelector(".ecoindex-grade");
  if (spanGrade) {
    spanGrade.textContent = "Grade " + grade;

    const gradeColors = {
      A: "#2e9b43",
      B: "#34bc6e",
      C: "#cadd00",
      D: "#f7ed00",
      E: "#ffce00",
      F: "#fb9929",
    };
    spanGrade.style.background = gradeColors[grade] || "#f01c16";
  }
})(Drupal, drupalSettings);
