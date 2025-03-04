
export function removeLocalStorage() {
    console.log("remove local storage");
    localStorage.removeItem("gameScoreID");
    localStorage.removeItem("gameID");
    localStorage.removeItem("gameName");
    localStorage.removeItem("teamName");
    localStorage.removeItem("timeStart");
    localStorage.removeItem("formattedDate");
    localStorage.removeItem("clueTextArray");
    localStorage.removeItem("solvedArray");
    localStorage.removeItem("hintTextArray");
    localStorage.removeItem("quesArray");
    localStorage.removeItem("hintUsedArray");
    localStorage.removeItem("gdo");
    localStorage.removeItem("gameSlug");
}