import { TextareaControl, TextControl, Button} from "@wordpress/components";
import {useState} from "react";

export default function FlexButtons({attributes,setAttributes}) {
    const [showWaiver, setShowWaiver] = useState(false);
    const [showHelp, setShowHelp] = useState(false);
    const [showMap1, setShowMap1] = useState(false);
    const [showMap1View, setShowMap1View] = useState(false);
    const [showMap2View, setShowMap2View] = useState(false);
    const [showHelpFields, setShowHelpFields] = useState(false);
    const [showWaiverFields, setShowWaiverFields] = useState(false);
    function updateZoneText(value) {
        console.log("update zone text");
        setAttributes({ zoneText: value })
    }
    function updatePuzzleText(value) {
        console.log("update puzzle text");
        setAttributes({ puzzleText: value })
    }
    function updateClueText(value) {
        console.log("update clue text");
        setAttributes({ clueText: value })
    }
    function updateHintText(value) {
        console.log("update hint text");
        setAttributes({ hintText: value })
    }
    function updateMap1(value) {
        console.log("update map 1");
        setAttributes({ map1: value })
    }
    function updateMap2(value) {
        console.log("update map 2");
        setAttributes({ map2: value })
    }
    function updatePublicMapText(value) {
        console.log("update publicMapText");
        setAttributes({ publicMapText: value })
    }
    function updateWaiverTop(value) {
        console.log("update waiver top");
        setAttributes({ waiverTop: value })
    }
    function updateWaiverBody(value) {
        console.log("update waiver body");
        setAttributes({ waiverBody: value })
    }
    return (
        <>
            <div className={"flex-button"}>
                <Button
                    isPrimary
                    onClick={() => {
                        setShowHelp(!showHelp);
                    }}
                >
                    <div className={showHelp ? "hide" : "show"}>Show Help for Game Design</div>
                    <div className={showHelp ? "show" : "hide"}>Close Help for Game Design</div>
                </Button>
                <Button
                    isPrimary
                    onClick={() => {
                        setShowHelpFields(!showHelpFields);
                    }}
                >
                    <div className={showHelpFields ? "hide" : "show"}>Show in-Game Help Fields</div>
                    <div className={showHelpFields ? "show" : "hide"}>Close in-Game Help Fields</div>
                </Button>
                <Button
                    isPrimary
                    onClick={() => {
                        setShowWaiverFields(!showWaiverFields);
                    }}
                >
                    <div className={showWaiverFields ? "hide" : "show"}>Show Waiver</div>
                    <div className={showWaiverFields ? "show" : "hide"}>Close Waiver</div>
                </Button>
                <Button
                    isPrimary
                    onClick={() => {
                        setShowMap1(!showMap1);
                    }}
                >
                    <div className={showMap1 ? "hide" : "show"}>Show Zones/Map Info</div>
                    <div className={showMap1 ? "show" : "hide"}>Close Zones/Map Info</div>
                </Button>

            </div>
            <div className={showHelp ? "show" : "hide"}>
                HOW TO CREATE A GAME:
                <ul>
                    <li>Do Not Publish Game for public until you are done testing. Create a private page with a
                        password.
                    </li>
                    <li>Games are based on Zones. Create a Zone and then create clues, puzzles, and hints</li>
                    <li>Zones are area with a radius of about 100 feet. Let the player know the center of the zone
                        AND/OR if it does not have a diameter of 100feet (if you change this, change help text for
                        zones, in-Game Help Field).
                    </li>
                    <li>Each game has a waiver - default text provided (you can change)</li>
                    <li>Each game has a help area for player - default text provided (you can change)</li>
                    <li>You can change color of background of game - see tool on right</li>
                    <li>Provide a header and description for each game.</li>
                    <li>Provide a Walking Distance for each game - estimated total walking distance for player, usually
                        based on
                        zones and how far apart.
                    </li>
                </ul>
            </div>
            <div className={showHelpFields ? "show" : "hide"}>
                <div className="text-area-container" id={"zone-help-text"}>
                    <TextareaControl label="Zone Help Text':" value={attributes.zoneText} onChange={updateZoneText}
                                     style={{fontSize: "15px"}}/>
                </div>
                <div className="text-area-container" id={"puzzle-help-text"}>
                    <TextareaControl label="Puzzle Help Text':" value={attributes.puzzleText}
                                     onChange={updatePuzzleText}
                                     style={{fontSize: "15px"}}/>
                </div>
                <div className="text-area-container" id={"clue-help-text"}>
                    <TextareaControl label="Clue Help Text':" value={attributes.clueText}
                                     onChange={updateClueText}
                                     style={{fontSize: "15px"}}/>
                </div>
                <div className="text-area-container" id={"hint-help-text"}>
                    <TextareaControl label="Hint Help Text':" value={attributes.hintText}
                                     onChange={updateHintText}
                                     style={{fontSize: "15px"}}/>
                </div>
            </div>
            <div className={showWaiverFields ? "show" : "hide"}>
                <div className="text-area-container">
                    <TextareaControl label="Waiver Top:" value={attributes.waiverTop} onChange={updateWaiverTop}
                                     style={{fontSize: "15px"}}/>
                    <TextareaControl label="Waiver Body':" value={attributes.waiverBody} onChange={updateWaiverBody}
                                     style={{fontSize: "15px"}}/>
                    <Button
                        isPrimary
                        onClick={() => {
                            setShowWaiver(!showWaiver);
                        }}
                    >
                        <div className={showWaiver ? "hide" : "show"}>View Waiver Text</div>
                        <div className={showWaiver ? "show" : "hide"}>Close Waiver Text</div>
                    </Button>
                    <div className={showWaiver ? "waiver-container show" : "hide"}>
                        <div className={"waiver-top"}>{attributes.waiverTop}</div>
                        <div className={"waiver-body"}>{attributes.waiverBody}</div>
                    </div>
                </div>
            </div>
            <div className={showMap1 ? "show flex-button-area" : "hide"}>
                <header class="modal_header"><strong>Public Map</strong></header>
                <div className="small">SRC ONLY: Get Map src for iframe using "create map" at
                    https://mymaps.google.com and look for an "Embed" link for iframe code, also suggest using base map as "simple atlas".
                </div>
                <div className="text-area-container">
                    <TextControl label="Public Map Src for iframe (if no src code, no map):" value={attributes.map1}
                                 onChange={updateMap1}
                                 style={{fontSize: "15px"}}/>
                    <TextControl
                        label="Zone / Public Map Explanation (description of what is on public map):"
                        value={attributes.publicMapText} onChange={updatePublicMapText}
                        style={{fontSize: "20px"}}/>


                </div>
                <header class="modal_header"><strong>Private/Zone Map</strong></header>

                <div className="text-area-container">
                    <TextControl label="Private/Zone Map Src for iframe (if no src code, no map):"
                                 value={attributes.map2}
                                 onChange={updateMap2}
                                 style={{fontSize: "15px"}}/>
                    <div className={"flex-button"}>
                        <Button
                            isPrimary
                            className={(attributes.map2 === "") ? "hide" : "show"}
                            onClick={() => {
                                setShowMap2View(!showMap2View);
                            }}
                        >
                            <div className={showMap2View ? "hide" : "show"}>View Private/Zone Map</div>
                            <div className={showMap2View ? "show" : "hide"}>Close Private/Zone Map</div>
                        </Button>
                        <Button
                            isPrimary
                            className={(attributes.map1 === "") ? "hide" : "show"}
                            onClick={() => {
                                setShowMap1View(!showMap1View);
                            }}
                        >
                            <div className={showMap1View ? "hide" : "show"}>View Public Map</div>
                            <div className={showMap1View ? "show" : "hide"}>Close Public Map</div>
                        </Button>
                    </div>
                </div>
            </div>
            <div className={showMap1View ? "showmodal modalContainerMap" : "hide modalContainerMap"}>
                <div class="modal from-right">
                    <header class="modal_header">
                        <div><strong>Public Map</strong> <span class={"small"}>(click on right arrow or icons for zone name(s))</span>
                        </div>
                    </header>
                    <main class="modal_content">
                        <iframe src={attributes.map1} width={"100%"} height={"400px"}></iframe>
                    </main>
                    <footer class="modal_footer">
                        <Button
                            isPrimary
                            onClick={() => {
                                setShowMap1View(!showMap1View);
                            }}
                        >
                            <div>Close Public Map</div>
                        </Button>
                    </footer>
                </div>
            </div>
            <div className={showMap2View ? "showmodal modalContainerMap" : "hide modalContainerMap"}>
                <div class="modal from-right">
                    <header class="modal_header">
                        <div><strong>Private/Zone Map</strong> <span class={"small"}>(click on right arrow or icons for zone name(s))</span>
                        </div>
                    </header>
                    <main class="modal_content">
                        <iframe src={attributes.map2} width={"100%"} height={"400px"}></iframe>
                    </main>
                    <footer class="modal_footer">
                        <Button
                            isPrimary
                            onClick={() => {
                                setShowMap2View(!showMap2View);
                            }}
                        >
                            <div>Close Private/Zone Map</div>
                        </Button>
                    </footer>
                </div>
            </div>

        </>
    )
}