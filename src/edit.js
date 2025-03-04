/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, BlockControls, AlignmentToolbar,RichText,RichTextToolbarButton  } from "@wordpress/block-editor";
import { TextControl, TextareaControl, Flex, FlexItem, Button, PanelBody, PanelRow,
	ColorPicker, RadioControl, Toolbar, ToolbarButton, Dashicon, TextDecorationControl} from "@wordpress/components";
import { formatBold, formatItalic, link } from '@wordpress/icons';
import { registerFormatType, toggleFormat } from '@wordpress/rich-text';
import { useState, useEffect} from 'react';




/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

import {randID} from "./components/randID";
import PuzzleEdit from "./components/PuzzleEdit";
import ClueEdit from "./components/ClueEdit";
import HintEdit from "./components/HintEdit";
import ZoneEdit from "./components/ZoneEdit";
import FlexButtons from "./components/FlexButtons";
import {editArrayItem} from "./components/manageArrayItem";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const [gameNameError, setGameNameError] = useState("");
	const allowedBlocks = [ 'core/heading','core/paragraph' ];

	const MY_TEMPLATE = [
		/*['core/heading', { level: 3, placeholder: 'Insert your heading here...' }],*/
		['core/paragraph', { placeholder: 'Write some description about game here - goals, notes about play area, etc ...' }],
	]
	const blockProps = useBlockProps();
	const playZoneObject = {
	 	"id": "",
		"name": "",
		"description": "",
		"lat": "",
		"long": "",
		"imageID": "",
		"order": "",
		"disabled": "No",
	}
	const puzzleObject = {
		"name": "",
		"clue": "",
		"question": "",
		"sols":[""],
		"answer":[""],
		"iconName": "",
		"iconPath": "",
		"order": "",
		"disabled": "No",
	}
	const clueObject = {
		"name": "",
		"text": "",
		"iconName": "",
		"iconPath": "",
		"imageID": "",
		"order": "",
		"disabled": "No",
	}
	const hintObject = {
		"name": "",
		"text": "",
		"order": "",
		"disabled": "No",
	}
	// When the block loads, set playZones Array if not set or is just using default data
	useEffect( () => {
		if ( attributes.playZones.length===1 && attributes.playZones[0].id === "1") {
			console.log("playZones.length: " + attributes.playZones.length)
			console.log("playZones id: " + JSON.stringify(attributes.playZones))
			//add object to array
			/* edit zone id */
			//const zoneID = randID(6)
			//setAttributes({playZones: attributes.playZones.concat([{"id": zoneID,"name": "", "description": "", "lat": "", "long": "", "order": ""}])})
			// delete first index of playZone array because it just wasn't editable
			deletePlayZone(0)
		}
	}, [] );
	function updateGameName(value) {
		console.log("update game name");
		setAttributes({ gameName: value })
	}
	function updateMission(value) {
		console.log("update mission");
		setAttributes({ mission: value })
	}
	function updateWalkingDistance(value) {
		console.log("update walking distance");
		setAttributes({ walkingDistance: value })
	}
	function updateUserMustBeLoggedIn(value) {
		console.log("update userMustBeLoggedIn");
		setAttributes({ userMustBeLoggedIn: value })
	}

	function deletePlayZone(indexToDelete) {
		console.log("deletePlayZone")
		const newPlayZones = attributes.playZones.filter(function (x, index) {
			return index != indexToDelete
		})
		setAttributes({ playZones: newPlayZones })
	}

	function addZoneInit() {
		console.log("addZone!")
		/* check zone id */
		const zoneID = randID(6)
		console.log("zoneID: " + zoneID)
		/* check game name */
		if (attributes.gameName === "update game name") {
			/* error */
			setGameNameError("please provide a game name");
		} else {
			/* set first zone */
			let newPlayZoneObject = {...playZoneObject}
			newPlayZoneObject.id = zoneID
			setAttributes({playZones: attributes.playZones.concat([newPlayZoneObject])})
			/* set gameID */
			let gameIDnew = zoneID + "-" + attributes.gameName.replace(/ /g, "-");;
			setAttributes({ gameID: gameIDnew })
		}
	}
	function addZone() {
		console.log("addZone!")
		/* check zone id */
		const zoneID = randID(6)
		console.log("zoneID: " + zoneID)
		let newPlayZoneObject = {...playZoneObject}
		newPlayZoneObject.id = zoneID
		setAttributes({playZones: attributes.playZones.concat([newPlayZoneObject])})

	}
	function addPuzzleObject(index) {
		console.log("addPuzzle")
		const newArray = attributes.playZones.concat([]);
		const newObject = newArray[index];
		/* check for puzzleArray on object */
		if (Object.hasOwn(newObject, 'puzzleArray')) {
			newObject.puzzleArray.push(puzzleObject);
		} else {
			newObject.puzzleArray=[puzzleObject];
		}
		// ****
		// using = to copy keeps all the references so don't have to do this 2nd equal after changing
		// note, if the object has more levels the first level copying with spread (...) will still have reference if you copy
		// that way.   JSON.parse(JSON.stringify) will copy all levels without reference but messes up on undefines, symbols, etc
		// -> don't need: newArray[index] = newObject;
		// ******
		//console.log("puzzleArray newArray[index]1: " + JSON.stringify(newArray[index]));
		//console.log("puzzleArray newObject2: " + JSON.stringify(newObject));
		//console.log("puzzleArray newArray: " + JSON.stringify(newArray));
		setAttributes({playZones: newArray});
	}
	function addClueObject(index) {
		console.log("addClue");
		const newArray = attributes.playZones.concat([]);
		const newObject = newArray[index];
		/* check for clueArray on object */
		if (Object.hasOwn(newObject, 'clueArray')) {
			newObject.clueArray.push(clueObject);
		} else {
			newObject.clueArray=[clueObject];
		}
		setAttributes({playZones: newArray});
	}
	function addHintObject(index) {
		console.log("addHint");
		const newArray = attributes.playZones.concat([]);
		const newObject = newArray[index];
		/* check for clueArray on object */
		if (Object.hasOwn(newObject, 'hintArray')) {
			newObject.hintArray.push(hintObject);
		} else {
			newObject.hintArray=[hintObject];
		}
		setAttributes({playZones: newArray});
	}
	function editZone(field, newValue, index) {
		const newArray = attributes.playZones.concat([]);
		/*if (Object.hasOwn(newArray[index], field)) {
			console.log("has field: ");
		} else {
			console.log("does not has field: ");
		}*/
		newArray[index][field] = newValue;
		console.log("playZones newArray: " + JSON.stringify(newArray));
		setAttributes({playZones: newArray});
	}
	function editZoneMedia(media, index) {
		//console.log("editClueMedia: " + JSON.stringify(media));
		const newArray = attributes.playZones.concat([]);
		newArray[index]["imageID"] = media.id;
		newArray[index]["imageURL"] = media.url;
		//console.log("playZones newArray: " + JSON.stringify(newArray));
		setAttributes({playZones: newArray});
	}
	function removeImage(index) {
		//console.log("editClueMedia: " + JSON.stringify(media));
		const newArray = attributes.playZones.concat([]);
		newArray[index]["imageID"] = "";
		newArray[index]["imageURL"] = "";
		//console.log("playZones newArray: " + JSON.stringify(newArray));
		setAttributes({playZones: newArray});
	}
	function hideZoneDiv(index) {
		const zoneDivID = "zoneDiv-" + index;
		const zoneShowID = "zoneShow-" + index;
		document.getElementById(zoneDivID).style.display = "none";
		document.getElementById(zoneShowID).style.display = "block";
	}
	function showZoneDiv(index) {
		const zoneDivID = "zoneDiv-" + index;
		const zoneShowID = "zoneShow-" + index;
		document.getElementById(zoneDivID).style.display = "block";
		document.getElementById(zoneShowID).style.display = "none";
	}

	if (attributes.playZones.length>0) {
	return (
		<div {...blockProps}>
			<div className="game-block-edit-block" style={{backgroundColor: attributes.bgColor}}>
				<div className="like-label">Note: (on right for EO Game) Please set Level, Location (include location, city), and category (city - to match on location)</div>
				<FlexButtons attributes={attributes} setAttributes={setAttributes}/>
				<TextControl label="Game Name:" value={attributes.gameName} onChange={updateGameName}
							 style={{fontSize: "20px"}}/>
				<TextControl label="Mission:" value={attributes.mission} onChange={updateMission}
							 style={{fontSize: "20px"}}/>
				<div className="like-label">Game Description (please provide an excerpt too):</div>
				<div style={{backgroundColor: "white", padding: "10px", marginBottom: "10px"}}>
					<InnerBlocks
						allowedBlocks={allowedBlocks} template={MY_TEMPLATE}
						templateLock="all"/>
				</div>
				<BlockControls>

				</BlockControls>
				<InspectorControls>
					<PanelBody title="Background Color" initialOpen={true}>
						<PanelRow>
							<ColorPicker
								color={attributes.bgColor}
								onChange={x => setAttributes({bgColor: x})}
								enableAlpha
								defaultValue="#000"
							/>
						</PanelRow>
					</PanelBody>
					<PanelBody title="Text Color" initialOpen={true}>
						<PanelRow>
							<ColorPicker
								color={attributes.textColor}
								onChange={x => setAttributes({textColor: x})}
								enableAlpha
								defaultValue="#000"
							/>
						</PanelRow>
					</PanelBody>
				</InspectorControls>


				<RadioControl
					label="User Logged In? (score is saved only for logged in Users)"
					selected={ attributes.userMustBeLoggedIn }
					options={ [
						{ label: 'User Must Be Logged in to Play', value: "yes"},
						{ label: 'Anyone can play, User does not need to log in', value: "no" },
					] }
					onChange={ ( value ) => updateUserMustBeLoggedIn( value ) }
				/>


				<div className={"item-holder-edit"}>
					{attributes.playZones.map(function (playZone, index) {
						return (
							<>
							<div id={"zoneShow-" + index} style={{display: "none",marginBottom:"10px"}}>
								<Button
									isPrimary
									onClick={() => {
										showZoneDiv(index)
									}}
								>
									Show {playZone.name}
								</Button>

							</div>
							<div id={"zoneShow-" + index} style={{display: "block"}}>
								<div key={index} id={"zoneDiv-" + index}>
									<div className="item-title-edit">Zones {index + 1}:
									<Button
										isTertiary
										onClick={() => {
											hideZoneDiv(index)
										}}
									>
										(hide zone)
									</Button>
									</div>
									<ZoneEdit playZone={playZone} index={index} editZoneMedia={editZoneMedia}
											  removeImage={removeImage}
											  editZone={editZone} deletePlayZone={deletePlayZone}/>
									<Flex justify={"flex-start"} className={"buttons"}>
										<FlexItem>
											<Button
												isPrimary
												onClick={() => {
													addPuzzleObject(index)
												}}
											>
												Add Puzzle&nbsp;<span className={"small"}>({playZone.name})</span>
											</Button>
										</FlexItem>
										<FlexItem>
											<Button
												isPrimary
												onClick={() => {
													addClueObject(index)
												}}
											>
												Add Clue&nbsp;<span className={"small"}>({playZone.name})</span>
											</Button>
										</FlexItem>
										<FlexItem>
											<Button
												isPrimary
												onClick={() => {
													addHintObject(index)
												}}
											>
												Add Hint&nbsp;<span className={"small"}>({playZone.name})</span>
											</Button>
										</FlexItem>

									</Flex>
									<div className={"item-holder-edit"}>
										<PuzzleEdit puzzleArray={playZone.puzzleArray} index={index}
													attributes={attributes} setAttributes={setAttributes}
													playZoneName={playZone.name}/>
									</div>
									<div className={"item-holder-edit"}>
										<ClueEdit clueArray={playZone.clueArray} index={index} attributes={attributes}
												  setAttributes={setAttributes} playZoneName={playZone.name}/>
									</div>
									<div className={"item-holder-edit"}>
										<HintEdit hintArray={playZone.hintArray} index={index} attributes={attributes}
												  setAttributes={setAttributes} playZoneName={playZone.name}/>
									</div>
								</div>
							</div>
							</>
						)
					})}
				</div>

				<Flex>
							<FlexItem>
								<Button
									isPrimary
									onClick={() => {
								addZone();
							}}
						>
							Add Another Zone
						</Button>
					</FlexItem>
				</Flex>


			</div>
		</div>
	);
	} else {
		return (
			<div {...blockProps}>
				<div className="game-block-edit-block" style={{backgroundColor: attributes.bgColor}}>
					<h4>The first step to creating a game is adding a Zone.</h4>
				<div>Zones are areas where people will play. Your Clues and Puzzles should be about things in the Zone area.
				Typically Zones have a center and the play area is about 100 feet around center. Games can have more than 1 Zone.</div>
				<br />
				<Flex>
					<FlexItem>
						<TextControl label="Game Name:" value={attributes.gameName} onChange={updateGameName}
									 style={{fontSize: "20px"}}/>
						<div style={{color: 'red'}}>{gameNameError}</div>
						<Button
							isPrimary
							onClick={() => {
								addZoneInit();
							}}
						>
							Add A Zone
						</Button>


					</FlexItem>
				</Flex>
			</div>
		</div>
		);
	}
}