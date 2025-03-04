import { TextControl,Flex, FlexBlock, FlexItem, Button, RadioControl} from "@wordpress/components";
import {editArrayItem, deleteArrayItem} from "./manageArrayItem";

export default function HintEdit({hintArray,index,attributes,setAttributes,playZoneName}) {
    if (typeof hintArray != "undefined") {
        return(
            <>
                {hintArray?.map(function (hint, index2) {
                return (
                    <div key={index2} className={"puzzleDiv"}>
                        <div className={hint.disabled == "Yes" ? "disabled" : ""}></div>
                        <div className="item-title-edit">Hints {index2 + 1} (zone name: {playZoneName}):</div>
                        <Flex>
                            <FlexBlock>
                                <TextControl
                                    label="Hint Name"
                                    autoFocus={hint.name == undefined}
                                    value={hint.name}
                                    onChange={newValue => {
                                        editArrayItem("hint","name", newValue, index, index2, "", attributes, setAttributes)
                                    }}
                                />
                                <TextControl
                                    label="Hint Text"
                                    autoFocus={hint.text == undefined}
                                    value={hint.text}
                                    onChange={newValue => {
                                        editArrayItem("hint","text", newValue, index, index2, "", attributes, setAttributes)
                                    }}
                                />
                            </FlexBlock>

                            <Flex direction={"column"}>
                                <FlexItem>
                                    <RadioControl
                                        selected={hint.disabled}
                                        options={[
                                            {label: 'Live', value: 'No'},
                                            {label: 'Disabled', value: 'Yes'},
                                        ]}
                                        onChange={newValue => {
                                            editArrayItem("hint","disabled", newValue, index, index2, "", attributes, setAttributes)
                                        }}
                                    />
                                </FlexItem>
                                <FlexItem>
                                    <TextControl
                                        label="Order"
                                        style={{width: "50px"}}
                                        type={"number"}
                                        autoFocus={hint.order == undefined}
                                        value={hint.order}
                                        onChange={newValue => {
                                            editArrayItem("hint","order", newValue, index, index2, "", attributes, setAttributes)
                                        }}
                                    />
                                </FlexItem>
                                <FlexItem>
                                    <Button isLink className="attention-delete"
                                            onClick={() => deleteArrayItem("hint", hintArray,index,index2,attributes,setAttributes)}>
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
        <div>no hints</div>
        )
    }
}