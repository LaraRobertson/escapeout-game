
export function IconDisplay({iconPath,type}) {
    console.log("type: " + type);
    const siteURL =window.my_data.siteUrl;
    //console.log("siteURL:" + siteURL);
    //console.log("window.my_data.siteUrl:" + window.my_data.siteUrl);
    const imageURL = siteURL + iconPath + ".svg";
    if (iconPath !== "") {
        if (type === "puzzle") {
            const imageURLOpen = siteURL + iconPath + "-open.svg";
            return (
                <div>
                    <img src={imageURL}/>&nbsp;
                    <img src={imageURLOpen}/>
                </div>
            )
        } else {
            return (
                <div>
                    <img src={imageURL}/>
                </div>
            )
        }
    } else {
        return (
            <div>icon not set</div>
        )
    }
}