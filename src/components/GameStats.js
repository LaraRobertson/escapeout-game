// components/GameStats.js
import React, {useEffect, useState} from 'react';
import { Button } from "@wordpress/components";
import { format } from 'date-fns'
import apiFetch from '@wordpress/api-fetch';

export default function GameStats({ modalContent }) {
    const [gameStats, setGameStats] = useState([]);
    const myStatsFunction = async () => {
        const url = "/escapeout/v1/game-score/?gameID=" + modalContent.gameID;
        apiFetch({
            path: url,
            method: "GET"
        }).then((data) => {
            console.log(data);
            setGameStats(data);
        }).catch((error) => {
            console.log( 'Error: ' + error );
        });
    }

    useEffect(() => {
        console.log("***useEffect***:  myStatsFunction(): (gameStats)");;
        myStatsFunction();
    }, []);

    async function deleteGameScore({gameScoreID}) {
        console.log("gameScoreID: " + gameScoreID);
        const url = "/escapeout/v1/game-score-delete/" + gameScoreID;
        apiFetch({
            path: url,
            method: "DELETE"
        }).catch((error) => {
            console.log( 'Error: ' + error );
        });
        myStatsFunction();
    }

    async function approveGameComment({gameScoreID}) {
        const url = "/escapeout/v1/game-score-comment-approve/" + gameScoreID;
        apiFetch({
            path: url,
            method: "PATCH",
            data: {gameCommentPublicApproved: 'yes'},
        } ).then(  ( res ) => {
            console.log( res );
        }).catch((error) => {
            console.log( 'Error: ' + error );
        });
        myStatsFunction();
    }
    const GameScoreView = ({gameScoreArray}) => {
        //console.log("gameScoreArray: " + JSON.stringify(gameScoreArray));
        return (
            <div className="table-container" role="table" aria-label="game score">
                <div className="flex-table header-table" role="rowgroup">
                    <div className="flex-row " role="columnheader">Team Name</div>
                    <div className="flex-row " role="columnheader">Team Score</div>
                    <div className="flex-row" role="columnheader">Total Time</div>
                    <div className="flex-row" role="columnheader">Hint Time</div>
                    <div className="flex-row" role="columnheader">Finished</div>
                </div>
                {(gameScoreArray.length === 0) && <div><strong>No Game Scores</strong><hr /></div>}
                {gameScoreArray.map((score, index) => (
                    <div role="rowgroup" key={score.id}>
                        <div className="flex-table row">
                            <div className="flex-row first" role="cell">{index+1}: {score.teamName} <br />
                                <span className={"small"}>{score.userEmail}</span></div>
                            <div className="flex-row " role="cell">{score.totalTime}</div>
                            <div className="flex-row" role="cell">
                                {score.totalTime}
                            </div>
                            <div className="flex-row" role="cell">
                                {score.hintTime}
                            </div>
                            <div className="flex-row" role="cell">completed: {score.completed} | first? {score.firstTime}</div>

                        </div>
                        <div className="flex-table row">
                            <div className="flex-row " style={{width:"40%"}} role="cell">Public Comments: {score.gameCommentPublic} <br />-.<br /> approved? ({score.gameCommentPublicApproved})<br />
                                <Button  variant="primary"  onClick={() => approveGameComment({"gameScoreID": score.id})}>
                                    approve
                                </Button>
                            </div>
                            <div className="flex-row " role="cell">Private Comments: {score.gameCommentPrivate}</div>
                            <div className="flex-row " role="cell">Rating: {score.gameRating}</div>
                            <div className="flex-row" role="cell">TEST? {score.testing}<br />
                                    <Button variant="primary" onClick={() => deleteGameScore({"gameScoreID": score.id})}>
                                        delete {score.id}
                                    </Button>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        )
    }

    return (
        <>
            <header className="header">Game Name: {modalContent.action}</header>
            <div>
                    <div key={modalContent.gameID}>
                        <GameScoreView gameScoreArray = {gameStats}/>
                    </div>

            </div>
        </>
    );
}