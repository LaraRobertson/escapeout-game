/**
 * WordPress dependencies
 */
//import apiFetch from '@wordpress/api-fetch';
import { store, getContext } from '@wordpress/interactivity';
import {
	RegExpMatcher,
	TextCensor,
	englishDataset,
	englishRecommendedTransformers,
} from 'obscenity';
import { format } from 'date-fns'
import {shallowEqual} from "./components/ShallowEqual";
import {removeLocalStorage} from "./components/helper";
import {caesarCipher} from "./components/caesarCipher";

const matcher = new RegExpMatcher({
	...englishDataset.build(),
	...englishRecommendedTransformers,
});

/* only show console messages on localhost */
/*if (window.location.hostname !== 'escapeout-wp') {
	console.log = (function () {
		var console_log = console.log;
		var timeStart = new Date().getTime();

		return function () {
			var delta = new Date().getTime() - timeStart;
			var args = [];
			args.push((delta / 1000).toFixed(2) + ':');
			for (var i = 0; i < arguments.length; i++) {
				args.push(arguments[i]);
			}
			//console_log.apply(console, args);
		};
	})();
}*/
/* Basic + space + base64 encode application username:password for user who created? */
const getPublicDataNOTWORKING = async ({postID,nonce}) => {
	/* note - can only update fields that you created, probably because of authorization... */
	//console.log("nonce: " + my_custom_vars.nonce);
	const url = state.siteURL + "/wp-json/escapeout/v1/eo-game/" + postID;
	apiFetch({
		path: url,
		method: "GET"
	}).then((data) => {
		console.log(data);
	}).catch((error) => {
		console.log( 'Error: ' + error );
	});
}
const loadPublicMap = async (src) => {
	let mapContainer = document.getElementById("publicMapContainer");
	const iframes = mapContainer.getElementsByTagName('iframe');
	if (iframes.length === 0) {
		let iframePublic = document.createElement("iframe");
		iframePublic.src = src;
		iframePublic.width = "100%";
		iframePublic.height = "400";
		iframePublic.style.border = "0";
		iframePublic.title = "Public Map";

		mapContainer.appendChild(iframePublic);
	}
}
const loadPrivateMap = async (src) => {
	console.log("src: " + src);
	let mapContainer2 = document.getElementById("privateMapContainer");
	console.log("mapContainer2: " + JSON.stringify(mapContainer2));
	let iframePrivate = document.createElement("iframe");
	iframePrivate.src = src;
	iframePrivate.width = "640";
	iframePrivate.height = "480";
	iframePrivate.style.border = "0";
	iframePrivate.title = "Zone Map";

	mapContainer2.appendChild(iframePrivate);
}
const getPublicData = async ({postID,nonce}) => {
	const myHeaders = new Headers();
	myHeaders.append("Content-Type", "application/json");
	myHeaders.append("Access-Control-Allow-Headers", "Authorization, X-WP-Nonce, Content-Disposition, Content-MD5, Content-Type");
	myHeaders.append("Access-Control-Expose-Headers","X-WP-Total, X-WP-TotalPages, Link");
	//myHeaders.append( "Authorization", "Bearer " + btoa( 'lara:4lRX C2u5 igwa ckGX j2Dv jWLr' ));
	myHeaders.append( "Vary", "Origin" );
	myHeaders.append('X-WP-Nonce', nonce);
	/* get game data */
	const requestOptions = {
		method: "GET",
		headers: myHeaders,
		credentials: "same-origin"
	};
	//const url = state.siteURL + "/wp-json/escapeout/v1/eo-game/" + postID + "/?_wpnonce=" + nonce;
	const url = state.siteURL + "/wp-json/escapeout/v1/eo-game/" + postID;
	try {
		const response = await fetch(url, requestOptions)
		if (!response.ok) {
			console.error('url Request failed with status ' + response.status)
		}
		const data = await response.json();
		/* data is an array */
		//console.log("data: " + data.post_content);
		//console.log("data.length: " + data.length);
		if (data.hasOwnProperty("post_content")) {
			console.log("data: " + data.post_content);
			const firstIndex = data.post_content.indexOf("{");
			const lastIndex = data.post_content.indexOf("-->");
			let postAttributes = data.post_content.slice(firstIndex,lastIndex).trim();
			let postAttributesObj = JSON.parse(postAttributes);
			let quesArray = [];
			let clueTextArray = [];
			let hintTextArray = [];
			let paIndex = 0;
			let caIndex = 0;
			let haIndex = 0;
			console.log("firstIndex: " + firstIndex);
			console.log("lastIndex: " + lastIndex);
			console.log("postAttributes: " + postAttributes);
			console.log("postAttributes (question): " + postAttributesObj.playZones[0].puzzleArray[0].question);
			/* get attributes from post_content */
			for (let i=0; i<postAttributesObj.playZones.length;i++){
				if (postAttributesObj.playZones[i].disabled === "No") {
					if (postAttributesObj.playZones[i].hasOwnProperty("puzzleArray")) {
						for (let j=0; j<postAttributesObj.playZones[i].puzzleArray.length;j++){
							if (postAttributesObj.playZones[i].puzzleArray[j].disabled === "No") {
								let key = 'input'+paIndex;
								let value = postAttributesObj.playZones[i].puzzleArray[j].question;
								let newObject = {};
								newObject[key]=value;
								quesArray.push(newObject);
								paIndex++;
							}
						}
					}
					if (postAttributesObj.playZones[i].hasOwnProperty("clueArray")) {
						for (let j=0; j<postAttributesObj.playZones[i].clueArray.length;j++){
							if (postAttributesObj.playZones[i].clueArray[j].disabled === "No") {
								let key = 'clue'+caIndex;
								let value = postAttributesObj.playZones[i].clueArray[j].text;
								let newObject = {};
								newObject[key]=value;
								clueTextArray.push(newObject);
								caIndex++;
							}
						}
					}
					if (postAttributesObj.playZones[i].hasOwnProperty("hintArray")) {
						for (let j=0; j<postAttributesObj.playZones[i].hintArray.length;j++){
							if (postAttributesObj.playZones[i].hintArray[j].disabled === "No") {
								let key = 'hint'+haIndex;
								let value = postAttributesObj.playZones[i].hintArray[j].text;
								let newObject = {};
								newObject[key]=value;
								hintTextArray.push(newObject);
								haIndex++;
							}
						}
					}
				}
			}
			/* gameData */
			const gameDataObject = {
				"qa": {"qa":""},
				"cta": {"cta":""},
				"hta": {"hta":""},
				"sa": "",
				"hua": ""
			}
			gameDataObject.qa.qa = quesArray;
			gameDataObject.cta.cta = clueTextArray;
			gameDataObject.hta.hta = hintTextArray;
			console.log("gameDataObject: " + JSON.stringify(gameDataObject));
			localStorage.setItem('gdo',JSON.stringify(gameDataObject));
			state.gdo = gameDataObject;
			console.log("JSON.stringify(quesArray): " + JSON.stringify(quesArray));
			state.puzzleQuestionArray = quesArray;
			console.log("JSON.stringify(clueTextArray): " + JSON.stringify(clueTextArray));
			state.clueTextArray = clueTextArray;
			console.log("JSON.stringify(hintTextArray): " + JSON.stringify(hintTextArray));
			state.hintTextArray = hintTextArray;
		}
	} catch (error) {
		console.error('Error (get post_content):', error.message)
	}
}
const saveScore = async (gameScoreID, nonce) => {
	console.log("saveScore: " + gameScoreID);
	const myHeaders = new Headers();
	myHeaders.append("Content-Type", "application/json");
	myHeaders.append("Access-Control-Allow-Headers", "Authorization, X-WP-Nonce, Content-Disposition, Content-MD5, Content-Type");
	myHeaders.append("Access-Control-Expose-Headers","X-WP-Total, X-WP-TotalPages, Link");
	//myHeaders.append( "Authorization", "Bearer " + btoa( 'lara:4lRX C2u5 igwa ckGX j2Dv jWLr' ));
	myHeaders.append( "Vary", "Origin" );
	myHeaders.append('X-WP-Nonce', nonce);

	/* generate all variables - timeEnd, totalTime, firstTime, completed */
	// Do your operations to calculate time
	let endDate   = new Date().getTime();
	let minutes = (endDate - state.timeStart) / 60000;
	let totalTime = Number(minutes + (state.hintUsedArray.length * 5)).toFixed(2);
	console.log("totalTime: " + totalTime);
	state.gameScore = totalTime;
	state.showGameScore = true;
	const context = getContext();
	if (context.userMustBeLoggedIn) {
		/* hintTime is a state variable */
		const raw = JSON.stringify({
			"timeEnd": endDate,
			"totalTime": totalTime,
			"hintTime": state.hintUsedArray.length * 5,
			"completed": 'yes',
		});
		console.log("raw (put-saveScore)" + raw);

		const requestOptions = {
			method: "PATCH",
			headers: myHeaders,
			credentials: "same-origin",
			body: raw,
			redirect: "follow"
		};
		const url = state.siteURL + "/wp-json/escapeout/v1/game-score-complete/" + gameScoreID;
		try {
			const response = await fetch(url, requestOptions)
			if (!response.ok) {
				console.error('Request failed with status ' + response.status)
			}
		} catch (error) {
			console.error('Error:', error.message)
		}
	}
}
const handle_send_email = async (email,gameCommentPublic,siteURL,nonce) => {
	console.log("handle_send_email: " + email + " comment: " + gameCommentPublic);
	const myHeaders = new Headers();
	myHeaders.append("Content-Type", "application/json");
	myHeaders.append("Access-Control-Allow-Headers", "Authorization, X-WP-Nonce, Content-Disposition, Content-MD5, Content-Type");
	myHeaders.append("Access-Control-Expose-Headers","X-WP-Total, X-WP-TotalPages, Link");
	//myHeaders.append( "Authorization", "Bearer " + btoa( 'lara:4lRX C2u5 igwa ckGX j2Dv jWLr' ));
	myHeaders.append( "Vary", "Origin" );
	myHeaders.append('X-WP-Nonce', nonce);
	const raw = JSON.stringify({
		"to": email,
		"subject": "game comment",
		"message": gameCommentPublic
	});
	const requestOptions = {
		method: "POST",
		headers: myHeaders,
		body: raw,
		credentials: "include"
	};
	const emailURL = siteURL + "/wp-json/escapeout/v1/game-score-email/";
	console.log("emailURL: " + emailURL);
	try {
		const response = await fetch(emailURL, requestOptions)
		if (!response.ok) {
			console.error('url Request failed with status ' + response.status)
		}
	} catch (error) {
		console.error('Error (post handle-send-email):', error.message)
	}
}
const saveGameComments = async (gameScoreID, inputPublic, inputPrivate, rating, nonce, designerEmail ) => {
	console.log("saveGameComments: " + gameScoreID);
	const myHeaders = new Headers();
	myHeaders.append("Content-Type", "application/json");
	myHeaders.append("Access-Control-Allow-Headers", "Authorization, X-WP-Nonce, Content-Disposition, Content-MD5, Content-Type");
	myHeaders.append("Access-Control-Expose-Headers","X-WP-Total, X-WP-TotalPages, Link");
	//myHeaders.append( "Authorization", "Bearer " + btoa( 'lara:4lRX C2u5 igwa ckGX j2Dv jWLr' ));
	myHeaders.append( "Vary", "Origin" );
	myHeaders.append('X-WP-Nonce', nonce);
	const context = getContext();
	if (context.userMustBeLoggedIn) {
		/* hintTime is a state variable */
		const raw = JSON.stringify({
			"gameCommentPublic": inputPublic,
			"gameCommentPrivate": inputPrivate,
			"gameRating": rating,
		});
		console.log("raw (put-gameComments)" + raw);

		const requestOptions = {
			method: "PATCH",
			headers: myHeaders,
			credentials: "same-origin",
			body: raw,
			redirect: "follow"
		};
		const url = state.siteURL + "/wp-json/escapeout/v1/game-score-comment/" + gameScoreID;
		try {
			const response = await fetch(url, requestOptions)
			if (!response.ok) {
				console.error('Request failed with status (gameComments)' + response.status)
			}
			state.showGameScore = false;
			/* send email to ...*/

			handle_send_email(designerEmail,inputPublic,state.siteURL,nonce)
			/* reset all states */
			//window.location.reload();
			//window.scrollTo(0, 0);

		} catch (error) {
			console.error('Error (save game comments):', error.message)
		}
	}
};
const getScoreByID = async ({postID, userID, realTimeStart}) => {
}

const createScore = async ({postID, userID, gameID, gameName, gameSlug, userEmail, designerEmail, designerName, timeStart, formattedDate, teamName, testing, firstTime, nonce}) => {
	/* note - can only update fields that you created, probably because of authorization... */
	console.log("nonce: " + nonce);
	const context = getContext();
	const myHeaders = new Headers();
	myHeaders.append("Content-Type", "application/json");
	myHeaders.append("Access-Control-Allow-Headers", "Authorization, X-WP-Nonce, Content-Disposition, Content-MD5, Content-Type");
	myHeaders.append("Access-Control-Expose-Headers","X-WP-Total, X-WP-TotalPages, Link");
	//myHeaders.append( "Authorization", "Bearer " + btoa( 'lara:4lRX C2u5 igwa ckGX j2Dv jWLr' ));
	myHeaders.append( "Vary", "Origin" );
	myHeaders.append('X-WP-Nonce', nonce);
	/* get game data */
	const requestOptions = {
		method: "GET",
		headers: myHeaders,
		credentials: "same-origin"
	};
	const url = state.siteURL + "/wp-json/escapeout/v1/eo-game/" + postID;
	try {
		const response = await fetch(url, requestOptions)
		if (!response.ok) {
			console.error('url Request failed with status ' + response.status)
		}
		const data = await response.json();
		/* data is an array */
		//console.log("data: " + data.post_content);
		//console.log("data.length: " + data.length);
		if (data.hasOwnProperty("post_content")) {
			console.log("data: " + data.post_content);
			const firstIndex = data.post_content.indexOf("{");
			const lastIndex = data.post_content.indexOf("-->");
			let postAttributes = data.post_content.slice(firstIndex,lastIndex).trim();
			let postAttributesObj = JSON.parse(postAttributes);
			let quesArray = [];
			let clueTextArray = [];
			let hintTextArray = [];
			let paIndex = 0;
			let caIndex = 0;
			let haIndex = 0;
			console.log("firstIndex: " + firstIndex);
			console.log("lastIndex: " + lastIndex);
			console.log("postAttributes: " + postAttributes);
			console.log("postAttributes (question): " + postAttributesObj.playZones[0].puzzleArray[0].question);
			/* get attributes from post_content */
			for (let i=0; i<postAttributesObj.playZones.length;i++){
				if (postAttributesObj.playZones[i].disabled === "No") {
					if (postAttributesObj.playZones[i].hasOwnProperty("puzzleArray")) {
						for (let j=0; j<postAttributesObj.playZones[i].puzzleArray.length;j++){
							if (postAttributesObj.playZones[i].puzzleArray[j].disabled === "No") {
								let key = 'input'+paIndex;
								let value = postAttributesObj.playZones[i].puzzleArray[j].question;
								let newObject = {};
								newObject[key]=value;
								quesArray.push(newObject);
								paIndex++;
							}
						}
					}
					if (postAttributesObj.playZones[i].hasOwnProperty("clueArray")) {
						for (let j=0; j<postAttributesObj.playZones[i].clueArray.length;j++){
							if (postAttributesObj.playZones[i].clueArray[j].disabled === "No") {
								let key = 'clue'+caIndex;
								let value = postAttributesObj.playZones[i].clueArray[j].text;
								let newObject = {};
								newObject[key]=value;
								clueTextArray.push(newObject);
								caIndex++;
							}
						}
					}
					if (postAttributesObj.playZones[i].hasOwnProperty("hintArray")) {
						for (let j=0; j<postAttributesObj.playZones[i].hintArray.length;j++){
							if (postAttributesObj.playZones[i].hintArray[j].disabled === "No") {
								let key = 'hint'+haIndex;
								let value = postAttributesObj.playZones[i].hintArray[j].text;
								let newObject = {};
								newObject[key]=value;
								hintTextArray.push(newObject);
								haIndex++;
							}
						}
					}
				}
			}
			/* gameData */
			const gameDataObject = {
				"qa": {"qa":""},
				"cta": {"cta":""},
				"hta": {"hta":""},
				"sa": "",
				"hua": ""
			}
			gameDataObject.qa.qa = JSON.stringify(quesArray);
			gameDataObject.cta.cta = JSON.stringify(clueTextArray);
			gameDataObject.hta.hta = JSON.stringify(hintTextArray);
			console.log("gameDataObject: " + JSON.stringify(gameDataObject));
			localStorage.setItem('gdo',JSON.stringify(gameDataObject));
			state.gdo = gameDataObject;
			/* you can pretty easily figure this out if look at local variables, maybe should encrypt it all? */
			console.log("JSON.stringify(quesArray): " + JSON.stringify(quesArray));
			state.puzzleQuestionArray = quesArray;
			console.log("JSON.stringify(clueTextArray): " + JSON.stringify(clueTextArray));
			state.clueTextArray = clueTextArray;
			console.log("JSON.stringify(hintTextArray): " + JSON.stringify(hintTextArray));
			state.hintTextArray = hintTextArray;
		}
	} catch (error) {
		console.error('Error (get post_content):', error.message)
	}
	/* check if first time */
	/* don't need to check first time because am doing in stats */
	/* get game data */
		/* create score */
		const raw = JSON.stringify({
			"postID": postID,
			"userID": userID,
			"gameID": gameID,
			"gameName": gameName,
			"userEmail": userEmail,
			"designerEmail": designerEmail,
			"designerName": designerName,
			"timeStart": timeStart,
			"formattedDate": formattedDate,
			"firstTime": firstTime,
			"teamName": teamName,
			"testing": testing
		});
		const requestOptions2 = {
			method: "POST",
			headers: myHeaders,
			body: raw,
			credentials: "include"
		};
		const url2 = state.siteURL + "/wp-json/escapeout/v1/game-score/";
		try {
			const response = await fetch(url2, requestOptions2)
			if (!response.ok) {
				console.error('url2 Request failed with status ' + response.status)
				/* stop here */
			}
			/* get ID */
			const requestOptions3 = {
				method: "GET",
				headers: myHeaders,
				credentials: "include"
			};
			const url3 = state.siteURL + "/wp-json/escapeout/v1/game-score/?userEmail=" + userEmail + "&gameID=" + gameID + "&timeStart=" + timeStart;
			try {
				const response = await fetch(url3, requestOptions3)
				if (!response.ok) {
					console.error('url3 Request failed with status ' + response.status)
				}
				const data2 = await response.json();
				/*data is an array */
				console.log("data2: " + JSON.stringify(data2));
				if (data2.length>0) {
					state.gameScoreID = data2[0].id;
					localStorage.setItem("gameScoreID",data2[0].id);
					localStorage.setItem("gameName",gameName);
					localStorage.setItem("gameSlug",gameSlug);
					localStorage.setItem("timeStart", timeStart);
					localStorage.setItem("formattedDate", formattedDate);
					localStorage.setItem("gameID", gameID);
					context.gameStart = true;
				}
			} catch (error) {
				console.error('Error3 (get gameScoreID):', error.message)
			}

		} catch (error) {
			console.error('Error2 (post create score):', error.message)
		}
};
const { state } = store( 'escapeout-game', {
	state: {
		get themeText() {
			return state.isDark ? state.darkText : state.lightText;
		},
	},
	actions: {
		hintWarningOpen() {
			state.hintWarningVisible = true
		},
		hintWarningClose() {
			state.hintWarningVisible = false
		},
		saveTextArea: () => {
			const input = document.getElementById("textArea").value;
			console.log("textAreaInput" + input);
		},
		setHintDisplayOn: () => {
			const context = getContext();
			if (state.hintUsedArray.includes(context.hintID)) {
				state.hintDisplayOn = context.hintID;
				state.hintText = state.hintTextArray[context.hintIndex][context.hintID];
			} else {
				state.hintWarningVisible = true;
			}

		},
		openHint: () => {
			const context = getContext();
			context.hintUsed = true;
			state.hintWarningVisible = false;
			state.hintDisplayOn = context.hintID;
			state.hintText = state.hintTextArray[context.hintIndex][context.hintID];
			console.log("open hint: " + state.hintText);
			/* add to used hint array */
			state.hintUsedArray.push(context.hintID);
			//localStorage.setItem("hintUsedArray", JSON.stringify(state.hintUsedArray));
			/* gameData */
			const hintUsedArrayObject = {
				hua: state.hintUsedArray,
			}
			state.gdo = {...state.gdo,"hua":JSON.stringify(hintUsedArrayObject)};
			localStorage.setItem("gdo", JSON.stringify(state.gdo));
		},
		quitWarningClose: () => {
			state.hintID = '';
			state.hintWarningVisible = false;
		},
		setHintDisplayOff: () => {
			state.hintDisplayOn = "";
		},
		setClueDisplayOff: () => {
			state.clueDisplayOn = "";
		},
		setClueDisplayToggle: () => {
			const context = getContext();
			console.log("state.clueTextArray[0]['clue0']: " + state.clueTextArray[context.clueIndex][context.clueID]);
			state.clueText = state.clueTextArray[context.clueIndex][context.clueID];
			//context.clueDisplayOn = ! context.clueDisplayOn;
			/* just show one at a time to hide clue text */
			state.clueDisplayOn = context.clueID;
		},
		checkClueDisplayOn: () => {
			const context = getContext();
			if (state.clueDisplayOn = context.clueID) {
				return true
			} else {
				return false
			}
		},
		setZoneVisible: () => {
			const context = getContext();
			state.zoneID = context.id;
			console.log("context.description:" + context.description);
			if (context.description == "") {
				state.zoneDescription = " ";
			} else {
				state.zoneDescription = context.description;
			}
			if (context.name == "") {
				state.zoneName = " ";
			} else {
				state.zoneName = context.name;
			}
		},
		setPuzzleModalVisible: () => {
			const context = getContext();
			state.puzzleOpen = context.puzzleID;
			console.log("state.puzzleOpen: " + state.puzzleOpen);
			state.puzzleQuestion = state.puzzleQuestionArray[context.puzzleIndex][context.puzzleID];
			state.puzzleName = context.name;
			//console.log("context.modalOpen: " + context.modalOpen);
			console.log("state.puzzleOpen: " + state.puzzleOpen);
		},
		setPuzzleModalHidden: () => {
			state.puzzleOpen = "";
		},
		closeHelp: () => {
			console.log("closeHelp");
			state.zoneHelpVisible = false;
			state.puzzleHelpVisible = false;
			state.clueHelpVisible = false;
			state.hintHelpVisible = false;
			state.helpVisible = false;
		},
		toggleTeamHelp: () => {
			state.teamHelpVisible = ! state.teamHelpVisible;
		},
		toggleWaiverHelp: () => {
			state.waiverHelpVisible = ! state.waiverHelpVisible;
		},
		setZoneHelpVisible: () => {
			state.zoneHelpVisible = true;
			state.helpVisible = true;
		},
		setPuzzleHelpVisible: () => {
			state.puzzleHelpVisible = true;
			state.helpVisible = true;
		},
		setClueHelpVisible: () => {
			state.clueHelpVisible = true;
			state.helpVisible = true;
		},
		setHintHelpVisible: () => {
			state.hintHelpVisible = true;
			state.helpVisible = true;
		},

		togglePublicMap() {
			const context = getContext();
			loadPublicMap(context.map1);
			/*if (iframePublic.src === "") {
				iframePublic.src = context.map1;
			}*/
			state.modalPublicMapOpen = !state.modalPublicMapOpen;
		},
		togglePrivateMap() {
			console.log("togglePrivateMap");
			const context = getContext();
			loadPrivateMap(context.map2);
			/*if (iframePublic.src === "") {
				iframePublic.src = context.map1;
			}*/
			state.modalPrivateMapOpen = !state.modalPrivateMapOpen;
		},
		togglePublicImage() {
			state.modalPublicImageOpen = !state.modalPublicImageOpen;
		},
		toggleStats() {
			console.log("stats");
			state.modalStatsOpen = !state.modalStatsOpen;
		},
		toggleLeaderBoard() {
			state.modalLeaderBoardOpen = !state.modalLeaderBoardOpen;
		},
		saveGameComments: () => {
			const context = getContext();
			const inputPublic = document.getElementById("gameCommentPublic").value;
			const inputPrivate = document.getElementById("gameCommentPrivate").value;
			saveGameComments(state.gameScoreID, inputPublic, inputPrivate, state.rating, state.nonce, context.designerEmail);
		},
		guessAttempt: () => {
			const context = getContext();
			const input = document.getElementById(context.puzzleID).value;
			context.guess = input.trimEnd();
			/* now encrypt */
			console.log("guess: " + context.guess);
			console.log("shift: " + context.shift);
			let guessENC = caesarCipher(context.guess, Number(context.shift));
			/* loop thru answers */
			let val = false;
			for (let i = 0; i<context.sols.length;i++) {
				/* encrypt guess */
				val = shallowEqual(guessENC, context.sols[i]);
				if (val === true) {break;}
			}
			console.log("val: " + val);
			if (val) {
				state.solvedArray.push(context.puzzleID);
				//localStorage.setItem("solvedArray", JSON.stringify(state.solvedArray));
				//console.log("state: " + JSON.stringify(state));
				/* gameData */
				const solvedArrayObject = {
					sa: state.solvedArray,
				}
				state.gdo = {...state.gdo,"sa":JSON.stringify(solvedArrayObject)};
				localStorage.setItem("gdo", JSON.stringify(state.gdo));
				context.solved = true;
				context.timeEnd = Date();
				setTimeout(() => {
					//context.modalOpen = false;
					state.puzzleOpen = "";
				}, 1600);
				/* check if finished */
				if (state.solvedArray.length === state.puzzleQuestionArray.length) {
					state.alertVisible = true
					state.alertText = "Winner!"
					/* send to database */

					saveScore(state.gameScoreID, state.nonce);

					setTimeout(() => {
						removeLocalStorage();
						context.gameStart = false;
						console.log("finished game");
					}, 1600);
				}
			} else {
				context.showSorry = true;
				setTimeout(() => {
					context.showSorry = false
				}, 1600);
			}
			},
		toggleOpen() {
			const context = getContext();
			context.isOpen = ! context.isOpen;
		},
		quitAlertOpen() {
			state.quitVisible = true
		},
		quitAlertClose() {
			state.quitVisible = false
		},
		quitAlertStartClose() {
			state.alertStartVisible = false;
			const gameSlug = localStorage.getItem("gameSlug");
			const gameURL = state.siteURL + "/eo-game/" + gameSlug;
			window.location.assign(gameURL);
		},
		quit() {
			const context = getContext();
			removeLocalStorage();
			window.location.reload();
			window.scrollTo(0, 0);
		},
		showWaiverToggle() {
			state.showWaiver = ! state.showWaiver;
		},
		showTeamToggle() {
			state.showTeam = ! state.showTeam;
		},
		signWaiver() {
			const context = getContext();
			context.waiverSigned=true;
		},
		gameStart() {
			const context = getContext();
			/* no teamName in beginning for wordpress games
			/* teamName is displayName provided by wordpress
			if (context.userMustBeLoggedIn) {
				context.teamName = document.getElementById("team-name").value;
			} else {*/
				context.teamName = document.getElementById("team-name2").value;
			/*}*/
			console.log("context.teamName: " + context.teamName);
			console.log("context.gameName: " + context.gameName);
			console.log("context.gameID: " + context.gameID);
			const gameIDLocal = localStorage.getItem("gameID");
			const gameNameLocal = localStorage.getItem("gameName");
			/* gameURL so can redirect if playing more than one game */
			console.log ("localStorage.getItem-gameID: " + gameIDLocal )
			// check if playing another game
			if ( localStorage.getItem("timeStart") && (gameIDLocal !== context.gameID) ) {
				/* let them know they are currently playing a different game */
				console.log("setting alert start?");
				state.alertStartVisible = true;
				state.anotherGame = gameNameLocal;
				if (context.gameStart === true) {
					console.log("gameStart: true");
					state.alertText = "You are playing: " + gameNameLocal + ". gameStart is true";
				} else {
					console.log("gameStart: false");
					state.alertText = "You are playing: " + gameNameLocal + ". gameStart is true";
				}
			} else {
				// check waiver
				if (context.waiverSigned === true) {
					//check teamName
					if (context.teamName !== '') {
						console.log("context.teamName (again): " + context.teamName);
						/* check for obscenities */
						if (matcher.hasMatch(context.teamName)) {
							state.errorMessage = "The Team Name contains profanities. Please choose another.";
							context.teamName = "";
						} else {
							state.errorMessage = "";
							/* need teamName in localstorage? */
							//localStorage.setItem("teamName", context.teamName);
							/* this is timeStart */
							const date = new Date().getTime();
							/* ... */
							/* check for other games? */
							state.timeStart = date;
							state.formattedDate = format(date, "MM/dd/yy h:mma");
							/* do this after score is created */
							/*localStorage.setItem("timeStart", date);*/
							/* context.gameStart = true;*/
							state.gameScore = '';
							state.showGameScore = false;
							state.showWaiver = false;
							let testing = "";
							if (context.testKey === "eo-test-game") {
								testing = "testing";
							} else {
								testing = "live";
							}
							if (context.userMustBeLoggedIn) {
								createScore({
									postID: context.postID,
									userID: context.userID,
									gameID: context.gameID,
									gameName: context.gameName,
									gameSlug: context.gameSlug,
									userEmail: context.userEmail,
									designerEmail: context.designerEmail,
									designerName: context.designerName,
									timeStart: date,
									formattedDate: format(date, "MM/dd/yy h:mma"),
									teamName: context.teamName,
									firstTime: context.firstTime,
									testing: testing,
									nonce: state.nonce
								});
							} else {
								getPublicData({
									postID: context.postID, nonce: state.nonce
								});
								localStorage.setItem("gameName",context.gameName);
								localStorage.setItem("timeStart", date);
								localStorage.setItem("gameID", context.gameID);
								localStorage.setItem("gameSlug", context.gameSlug);
								context.gameStart = true;
							}
							/* get gameScoreID */
						}
					} else {
						//set errorMessage
						state.errorMessage = "Please choose a Team Name"
					}
				} else {
					state.errorMessage = "You Need to Sign Waiver";
				}
			}
		},
		toggleTheme() {
			state.isDark = ! state.isDark;
		},
		closeGameScore() {
			state.showGameScore = false;
			/* reset all states */
			window.location.reload();
			window.scrollTo(0, 0);
		},
		setRating1() {
			state.rating = 1;
			for (let i=1;i<6;i++){
				let ratingID = "rating" + i;
				document.getElementById(ratingID).classList.remove("ratings-chosen");
			}
			const ratingButton = document.getElementById("rating1");
			ratingButton.classList.add("ratings-chosen");
		},
		setRating2() {
			state.rating = 2;
			for (let i=1;i<6;i++){
				let ratingID = "rating" + i;
				document.getElementById(ratingID).classList.remove("ratings-chosen");
			}
			const ratingButton = document.getElementById("rating2");
			ratingButton.classList.add("ratings-chosen");
		},
		setRating3() {
			state.rating = 3;
			for (let i=1;i<6;i++){
				let ratingID = "rating" + i;
				document.getElementById(ratingID).classList.remove("ratings-chosen");
			}
			const ratingButton = document.getElementById("rating3");
			ratingButton.classList.add("ratings-chosen");
		},
		setRating4() {
			state.rating = 4;
			for (let i=1;i<6;i++){
				let ratingID = "rating" + i;
				document.getElementById(ratingID).classList.remove("ratings-chosen");
			}
			const ratingButton = document.getElementById("rating4");
			ratingButton.classList.add("ratings-chosen");
		},
		setRating5() {
			state.rating = 5;
			for (let i=1;i<6;i++){
				let ratingID = "rating" + i;
				document.getElementById(ratingID).classList.remove("ratings-chosen");
			}
			const ratingButton = document.getElementById("rating5");
			ratingButton.classList.add("ratings-chosen");
		},
	},
	callbacks: {
		puzzleOpen: () => {
			const context = getContext();
			if (state.puzzleOpen === context.puzzleID) {
				return true;
			} else {
				return false;
			}
		},
		hintTime: () => {
			const hintTime = state.hintUsedArray.length * 5;
			return hintTime;
		},
		checkSolved: () => {
			const context = getContext();
			if (state.solvedArray.includes(context.puzzleID)) {
				return true;
			}
		},
		clueDisplayOn: () => {
			const context = getContext();
			if (context.clueID === state.clueDisplayOn) {
				return true;
			} else {
				return false
			}
		},
		hintDisplayOn: () => {
			const context = getContext();
			if (context.hintID === state.hintDisplayOn) {
				return true;
			} else {
				return false
			}
		},
		checkPublicMap: () => {
			const context = getContext();
			if (context.map1 !== '') {
				console.log("don't hide map button");
				return false
			} else {
				console.log("hide map button");
				return true
			}
		},
		checkPrivateMap: () => {
			const context = getContext();
			if (context.map2 !== '') {
				console.log("don't hide map button");
				return false
			} else {
				console.log("hide map button");
				return true
			}
		},
		hideItemByZone: () => {
			const context = getContext();
			console.log("context.zoneID: " + context.zoneID);
			console.log("context.firstZoneID: " + context.firstZoneID);
			console.log("state.zoneID: " + state.zoneID);
			if ((context.zoneID == state.zoneID) || (state.zoneID === '' && context.zoneID === context.firstZoneID)) {
				console.log("don't hide zone");
				return false
			} else {
				console.log("hide zone");
				return true
			}
		},
		hideItemByZoneID: () => {
			const context = getContext();
			//console.log("context.zoneID: " + context.zoneID);
			console.log("context.id: " + context.id);
			console.log("context.firstZoneID: " + context.firstZoneID);
			console.log("state.zoneID: " + state.zoneID);
			if ((context.id == state.zoneID) || (state.zoneID === '' && context.id === context.firstZoneID)) {
				console.log("don't hide zone");
				return false
			} else {
				console.log("hide zone");
				return true
			}
		},
		setAlertText: () => {
			state.alertVisible = true;
			setTimeout(() => {
				state.alertVisible = false;
			}, 3000);
		},
		zoneBorder: () => {
			const context = getContext();
			if ((state.zoneID == context.id) || (state.zoneID === '' && context.firstZoneID == context.id))
				return true;
		},
		zoneDescription: () => {
			if (state.zoneDescription !== '') {
				return true;
			}
		},
		saveNotes: () => {
			const textareaElement = document.getElementById("textArea");
			console.log("textArea value: " + textareaElement.value);
		},
		checkGameStart: () => {
			const context = getContext();
			const gameIDLocal = localStorage.getItem('gameID');
			console.log("gameNameLocal: " + gameIDLocal);
			console.log("context.gameID: " + context.gameID);
			if (localStorage.getItem("timeStart")) {
				/* check game-name */
				if ( gameIDLocal === context.gameID) {
					/* reset states */
					state.gameScoreID = localStorage.getItem('gameScoreID')
					state.timeStart = localStorage.getItem('timeStart')
					state.formattedDate = localStorage.getItem('formattedDate')
					/* gameData */
					/* should consolidate and encrypt to make harder if someone tries to cheat? */
					if (localStorage.getItem("gdo")!=null) {
						state.gdo = JSON.parse(localStorage.getItem("gdo"));
						if (state.gdo.hasOwnProperty("cta")) {
							if (state.gdo.cta.hasOwnProperty("cta")) {
								state.clueTextArray = JSON.parse(state.gdo.cta.cta);
							}
						}
						if (state.gdo.hasOwnProperty("qa")) {
							if (state.gdo.qa.hasOwnProperty("qa")) {
								state.puzzleQuestionArray = JSON.parse(state.gdo.qa.qa);
							}
						}
						if (state.gdo.hasOwnProperty("hta")) {
							if (state.gdo.hta.hasOwnProperty("hta")) {
								state.hintTextArray = JSON.parse(state.gdo.hta.hta);
							}
						}
						if (JSON.parse(localStorage.getItem("gdo")).sa !== "")
						{
							state.solvedArray = JSON.parse(JSON.parse(localStorage.getItem("gdo")).sa).sa;
						}
						console.log("state.solvedArray.length: " + state.solvedArray.length);
						if (JSON.parse(localStorage.getItem("gdo")).hua !== "")
						{
							state.hintUsedArray  = JSON.parse(JSON.parse(localStorage.getItem("gdo")).hua).hua;
						}
						console.log("state.hintUsedArray.length: " + state.hintUsedArray.length);
					}
					/* end gdo, not finished */
					if (localStorage.getItem("quesArray")!=null) {
						//state.puzzleQuestionArray = JSON.parse(localStorage.getItem("quesArray"));
					}
					if (localStorage.getItem("clueTextArray")!=null) {
						//state.clueTextArray = JSON.parse(localStorage.getItem("clueTextArray"));
					}
					if (localStorage.getItem("hintTextArray")!=null) {
						//state.hintTextArray = JSON.parse(localStorage.getItem("hintTextArray"));
					}
					if (localStorage.getItem("solvedArray")!=null) {
						//state.solvedArray = JSON.parse(localStorage.getItem("solvedArray"));
					}
					if (localStorage.getItem("hintUsedArray")!=null) {
						//state.hintUsedArray = JSON.parse(localStorage.getItem("hintUsedArray"));
					}
					//alert('resuming game');
					state.alertStartVisible = false
					state.alertVisible = true
					state.alertText = "resuming game"
					setTimeout(() => {
						state.alertVisible = false
					}, 3000);
					if (context.gameStart === true) {
						console.log("gameStart: true");
					} else {
						console.log("gameStart: false");
					}
					context.gameStart = true;
				}
			}
		},
		logIsOpen: () => {
			const { isOpen } = getContext();
			console.log( `Is open: ${ isOpen }` );
		},
	},
} );
