import {caesarCipher} from "./caesarCipher";
import {randID,generateRandomNumber} from "./randID";
export function editArrayItem(itemType, field, newValue, index, index2, index3, attributes, setAttributes) {
    const newArray = attributes.playZones.concat([]);
    switch (itemType) {
        case "puzzle":
            console.log("shift: " + attributes.shift);
            let newShift = attributes.shift;
            if (newShift === 0) {
                newShift = generateRandomNumber(1,100);
                console.log("set shift: " + newShift);
                //setAttributes["shift"] = randID(2);
                setAttributes({ shift: newShift })
            }
            if (field === "answer") {
                /* answer is an array */
                const newArraySols = newArray[index]["puzzleArray"][index2]["sols"];
                const newArrayAnswer = newArray[index]["puzzleArray"][index2]["answer"];
                const encryptedText = caesarCipher(newValue, Number(newShift));
                newArrayAnswer[index3] =  newValue;
                newArraySols[index3] = caesarCipher(newValue, Number(newShift));
                //const decryptedText = caesarCipher(encryptedText, -3);
                //console.log(decryptedText); // "Hello World"
            } else if (field === "addAnswer") {
                /* add another answer */
                newArray[index]["puzzleArray"][index2].sols.push("");
                newArray[index]["puzzleArray"][index2].answer.push("");
            } else if (field === "iconName") {
                console.log("puzzle iconName: " + newValue);
                newArray[index]["puzzleArray"][index2][field] = newValue;
                const imageURL = "/wp-content/plugins/escapeout-game/assets/" + newValue;
                newArray[index]["puzzleArray"][index2]["iconPath"] = imageURL;
            } else {
                newArray[index]["puzzleArray"][index2][field] = newValue;
            }
            break;
        case "clue":
            newArray[index]["clueArray"][index2][field] = newValue;
            if (field === "iconName") {
                //const siteURL =window.my_data.siteUrl;
                //console.log("siteURL:" + siteURL);
                //console.log("window.my_data.siteUrl:" + window.my_data.siteUrl);
                const imageURL = "/wp-content/plugins/escapeout-game/assets/" + newValue;
                newArray[index]["clueArray"][index2]["iconPath"] = imageURL;
            }
            break;
        case "hint":
            newArray[index]["hintArray"][index2][field] = newValue;
            break;
    }
    setAttributes({playZones: newArray});
}

export function deleteArrayItem(itemType, itemArray, zoneIndex, indexToDelete,attributes,setAttributes) {
    const newArray = attributes.playZones.concat([]);
    const newItemArray = itemArray.filter(function (x, index) {
        return index != indexToDelete
    })
    switch (itemType) {
        case "puzzle":
            console.log("delete puzzle")
            if (newItemArray.length===0) {
                const newObject = newArray[zoneIndex];
                delete newObject.puzzleArray;
            } else {
                newArray[zoneIndex]["puzzleArray"] = newItemArray;
            }
            break;
        case "clue":
            console.log("delete clue")
            if (newItemArray.length===0) {
                const newObject = newArray[zoneIndex];
                delete newObject.clueArray;
            } else {
                newArray[zoneIndex]["clueArray"] = newItemArray;
            }
            break;
        case "hint":
            console.log("delete hint")
            if (newItemArray.length===0) {
                const newObject = newArray[zoneIndex];
                delete newObject.hintArray;
            } else {
                newArray[zoneIndex]["hintArray"] = newItemArray;
            }
            break;
    }
    setAttributes({playZones: newArray});
}