export const randID = (size) => {
    const nums = Array.from({ length: 10 }, (_, i) =>
        String.fromCharCode("0".charCodeAt(0) + i)
    );
    const alphabets = Array.from({ length: 26 }, (_, i) =>
        String.fromCharCode("a".charCodeAt(0) + i)
    );
    const chars = [...nums, ...alphabets];
    const rand = (length) => Math.floor(Math.random() * length);
    return Array.from({ length: size }, () => chars[rand(chars.length)]).join("");
}
export const generateRandomNumber = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}