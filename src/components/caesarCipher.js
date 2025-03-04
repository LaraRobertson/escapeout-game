
export function caesarCipher(str, shift) {
    let result = "";
    for (let i = 0; i < str.length; i++) {
        let charCode = str.charCodeAt(i);

        // Handle lowercase letters
        if (charCode >= 97 && charCode <= 122) {
            charCode = ((charCode - 97 + shift) % 26) + 97;
        }
        // Handle uppercase letters
        else if (charCode >= 65 && charCode <= 90) {
            charCode = ((charCode - 65 + shift) % 26) + 65;
        }

        result += String.fromCharCode(charCode);
    }
    return result;
}