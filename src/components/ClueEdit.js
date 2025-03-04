import { MediaUpload, MediaUploadCheck} from "@wordpress/block-editor";
import { TextControl, SelectControl, Flex, FlexBlock, FlexItem, Button, RadioControl} from "@wordpress/components";
import {IconDisplay} from "./IconDisplay";
import {__} from "@wordpress/i18n";
import {editArrayItem, deleteArrayItem} from "./manageArrayItem";

function editClueMedia(media, index, index2, attributes, setAttributes) {
    //console.log("editClueMedia: " + JSON.stringify(media));
    const newArray = attributes.playZones.concat([]);
    newArray[index]["clueArray"][index2]["imageID"] = media.id;
    newArray[index]["clueArray"][index2]["imageURL"] = media.url;
    //console.log("playZones newArray: " + JSON.stringify(newArray));
    setAttributes({playZones: newArray});
}
export default function ClueEdit({clueArray,index,attributes,setAttributes,playZoneName}) {
    const ALLOWED_MEDIA_TYPES = [ 'image' ];
    if (typeof clueArray != "undefined") {
    return(
        <>
        {clueArray?.map(function (clue, index2) {
                return (
                    <div key={index2} className={"clueDiv"}>
                        <div className={clue.disabled == "Yes" ? "disabled" : ""}></div>
                        <div className="item-title-edit">Clues {index2 + 1} (zone name:  {playZoneName}):</div>
                        <Flex>
                            <FlexBlock>
                                <TextControl
                                    label="Clue Name"
                                    autoFocus={clue.name == undefined}
                                    value={clue.name}
                                    onChange={newValue => {
                                        editArrayItem("clue","name", newValue, index, index2, "", attributes, setAttributes)
                                    }}
                                />
                                <TextControl
                                    label="Clue Text"
                                    autoFocus={clue.text == undefined}
                                    value={clue.text}
                                    onChange={newValue => {
                                        editArrayItem("clue","text", newValue, index, index2, "", attributes, setAttributes)
                                    }}
                                />
                                <SelectControl
                                    label="Icon"
                                    value={clue.iconName}
                                    options={[
                                        {label: 'choose icon', value: ''},
                                        {label: 'magnifying glass', value: 'magnifying-glass'},
                                        {label: 'torn paper', value: 'torn-paper'},
                                        {label: 'envelope', value: 'envelope'},
                                        {
                                            label: 'message in a bottle',
                                            value: 'message-in-a-bottle'
                                        },
                                        {label: 'note question', value: 'note-question'},
                                        {label: 'diary', value: 'diary'},
                                    ]}
                                    onChange={newValue => {
                                        editArrayItem("clue","iconName", newValue, index, index2, "", attributes, setAttributes)
                                    }}
                                    __nextHasNoMarginBottom
                                />
                                <div>
                                    <IconDisplay iconPath = {clue.iconPath}  type={"clue"} />
                                </div>
                            </FlexBlock>
                            <FlexBlock>
                                <MediaUploadCheck>
                                    <MediaUpload
                                        onSelect={ media => {
                                            editClueMedia(media, index, index2, attributes, setAttributes)
                                        }}
                                        title={ __( 'Clue Image', 'game-block' ) }
                                        allowedTypes={ ALLOWED_MEDIA_TYPES }
                                        multiple={ false }
                                        value={ clue.imageID }
                                        render={ ( { open } ) => (
                                            <>
                                                <Button className="button" onClick={ open }>Open Media Library</Button>
                                                {
                                                    clue.imageURL && (
                                                        <img
                                                            src={ clue.imageURL }
                                                            alt={ __( 'Clue Image', 'game-block' ) }
                                                            style={{
                                                                display: 'block',
                                                                maxWidth: '250px',
                                                                height: 'auto',
                                                            }}
                                                        />
                                                    )
                                                }
                                            </>

                                        ) }
                                    />
                                </MediaUploadCheck>
                            </FlexBlock>

                            <Flex direction={"column"}>
                                <FlexItem>
                                    <RadioControl
                                        selected={clue.disabled}
                                        options={[
                                            {label: 'Live', value: 'No'},
                                            {label: 'Disabled', value: 'Yes'},
                                        ]}
                                        onChange={newValue => {
                                            editArrayItem("clue","disabled", newValue, index, index2, "", attributes, setAttributes)
                                        }}
                                    />
                                </FlexItem>
                                <FlexItem>
                                    <TextControl
                                        label="Order"
                                        style={{width: "50px"}}
                                        type={"number"}
                                        autoFocus={clue.order == undefined}
                                        value={clue.order}
                                        onChange={newValue => {
                                            editArrayItem("clue","order", newValue, index, index2, "", attributes, setAttributes)
                                        }}
                                    />
                                </FlexItem>
                                <FlexItem>
                                    <Button isLink className="attention-delete"
                                            onClick={() => deleteArrayItem("clue", clueArray,index,index2,attributes,setAttributes)}>
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
            <div>no clues</div>
        )
    }
}