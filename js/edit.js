((Drupal, drupalSettings) => {
  // Get nid.
  const nid = drupalSettings.ecoindex.nid;

  // Get EcoIndex field_name.
  const field = drupalSettings.ecoindex.field;

  // Get score and save it.
  const score = localStorage.getItem("ecoindex.score.en." + nid);
  if (score) {
    document.getElementById("edit-" + field.replace("_", "-") + "-0-score").value = score;
    localStorage.removeItem("ecoindex.score.en." + nid);
  }

  // Get grade and save it.
  const grade = localStorage.getItem("ecoindex.grade.en." + nid);
  if (grade) {
    document.getElementById("edit-" + field.replace("_", "-") + "-0-grade").value = grade;
    localStorage.removeItem("ecoindex.grade.en." + nid);
  }
})(Drupal, drupalSettings);
