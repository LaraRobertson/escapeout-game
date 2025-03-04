import { TextControl, Flex, FlexBlock, FlexItem, Button, RadioControl, SelectControl} from "@wordpress/components";
import {editArrayItem, deleteArrayItem} from "./manageArrayItem";
import {IconDisplay} from "./IconDisplay";
export default function PuzzleEdit({puzzleArray,index,attributes,setAttributes,playZoneName}) {
    if (typeof puzzleArray != "undefined") {
        return(
            <>
                {puzzleArray?.map(function (puzzle, index2) {
                    return (
                        <div key={index2} className={"puzzleDiv"}>
                            <div className={puzzle.disabled == "Yes" ? "disabled" : ""}></div>
                            <div className="item-title-edit">Puzzles {index2 + 1} ({playZoneName}):</div>
                            <Flex className={"puzzle-flex"}>
                                <FlexBlock>
                                    <TextControl
                                        label="Puzzle Name"
                                        autoFocus={puzzle.name == undefined}
                                        value={puzzle.name}
                                        onChange={newValue => {
                                            editArrayItem("puzzle","name", newValue, index, index2, "", attributes, setAttributes)
                                        }}
                                    />

                                    <TextControl
                                        label="Puzzle Question"
                                        autoFocus={puzzle.question == undefined}
                                        value={puzzle.question}
                                        onChange={newValue => {
                                            editArrayItem("puzzle","question", newValue, index, index2, "", attributes, setAttributes)
                                        }}
                                    />
                                    <TextControl
                                        label="Puzzle Clue - shows after solving (opt)"
                                        autoFocus={puzzle.clue == undefined}
                                        value={puzzle.clue}
                                        onChange={newValue => {
                                            editArrayItem("puzzle","clue", newValue, index, index2, "", attributes, setAttributes)
                                        }}
                                    />
                                    <SelectControl
                                        label="Icon"
                                        value={puzzle.iconName}
                                        options={[
                                            {label: 'choose icon', value: ''},
                                            {label: 'safe', value: 'safe'},
                                            {label: 'safe2', value: 'safe2'},
                                            {label: 'money safe', value: 'money-safe'},
                                            {
                                                label: 'locker',
                                                value: 'locker'
                                            },
                                            {label: 'chest', value: 'chest'},
                                            {label: 'chest2', value: 'chest2'},
                                        ]}
                                        onChange={newValue => {
                                            editArrayItem("puzzle","iconName", newValue, index, index2, "", attributes, setAttributes)
                                        }}
                                        __nextHasNoMarginBottom
                                    />
                                    <div>
                                        <IconDisplay iconPath = {puzzle.iconPath} type={"puzzle"}/>
                                    </div>
                                </FlexBlock>
                                <FlexBlock>
                                    {puzzle.answer.map(function (answerItem, index3) {
                                        return (
                                            <TextControl
                                                label={"answer " + (index3 + 1)}
                                                autoFocus={answerItem == undefined}
                                                value={answerItem}
                                                onChange={newValue => {
                                                    editArrayItem("puzzle","answer", newValue, index, index2, index3, attributes, setAttributes)
                                                }}
                                            />
                                        )
                                    })}
                                    {puzzle.sols.map(function (answerItem2, index4) {
                                        return (
                                           <div className={"small"}>encrypted answer {index4}: {answerItem2}</div>
                                        )
                                    })}
                                    <Button
                                        isPrimary
                                        onClick={() => {
                                            editArrayItem("puzzle","addAnswer", "", index, index2, "", attributes, setAttributes)
                                        }}
                                    >
                                        Add Another Answer
                                    </Button>


                                </FlexBlock>
                                <Flex direction={"column"}>
                                    <FlexItem>
                                        <RadioControl
                                            selected={puzzle.disabled}
                                            options={[
                                                {label: 'Live', value: 'No'},
                                                {label: 'Disabled', value: 'Yes'},
                                            ]}
                                            onChange={newValue => {
                                                editArrayItem("puzzle","disabled", newValue, index, index2, "", attributes, setAttributes)
                                            }}
                                        />
                                    </FlexItem>
                                    <FlexItem>
                                        <TextControl
                                            label="Order"
                                            style={{width: "50px"}}
                                            type={"number"}
                                            autoFocus={puzzle.order == undefined}
                                            value={puzzle.order}
                                            onChange={newValue => {
                                                editArrayItem("puzzle","order", newValue, index, index2, "", attributes, setAttributes)
                                            }}
                                        />
                                    </FlexItem>
                                    <FlexItem>
                                        <Button isLink className="attention-delete"
                                                onClick={() => deleteArrayItem("puzzle", puzzleArray,index,index2,attributes,setAttributes)}>
                                            Delete
                                        </Button>
                                    </FlexItem>
                                </Flex>
                            </Flex>
                        </div>
                    )
                })}
            </>
        )
    } else {
        return (
            <div>no puzzles</div>
        )
    }


}