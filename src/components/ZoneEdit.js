import { MediaUpload, MediaUploadCheck} from "@wordpress/block-editor";
import { TextControl, FlexBlock, Flex, RadioControl, FlexItem, Button} from "@wordpress/components";
import {__} from "@wordpress/i18n";
import AttachmentImage from "./AttachmentImage";


export default function ZoneEdit({playZone,index,editZoneMedia, removeImage, editZone, deletePlayZone}) {
    const ALLOWED_MEDIA_TYPES = [ 'image' ];
    return (
        <>
            <div className={playZone.disabled == "Yes" ? "disabled" : ""}></div>
            <Flex gap={"20px"}>
                <div className={"flexBlock200"}>
                    <TextControl
                        label="Zone Name"
                        autoFocus={playZone.name == undefined}
                        value={playZone.name}
                        onChange={newValue => {
                            editZone("name", newValue, index)
                        }}
                    />
                    <TextControl
                        label="Zone Description"
                        autoFocus={playZone.description == undefined}
                        value={playZone.description}
                        onChange={newValue => {
                            editZone("description", newValue, index)
                        }}
                    />
                    <TextControl
                        label="Latitude"
                        className={"hide"}
                        autoFocus={playZone.lat == undefined}
                        value={playZone.lat}
                        onChange={newValue => {
                            editZone("lat", newValue, index)
                        }}
                    />
                    <TextControl
                        label="Longitude"
                        className={"hide"}
                        autoFocus={playZone.long == undefined}
                        value={playZone.long}
                        onChange={newValue => {
                            editZone("long", newValue, index)
                        }}
                    />
                    <Flex justify={"flex-start"} wrap={"true"} gap={"20px"}>
                        <RadioControl
                            selected={playZone.disabled}
                            options={[
                                {label: 'Live', value: 'No'},
                                {label: 'Disabled', value: 'Yes'},
                            ]}
                            onChange={newValue => {
                                editZone("disabled", newValue, index)
                            }}
                        />
                        <TextControl
                            label="Order"
                            style={{width: "50px"}}
                            type={"number"}
                            autoFocus={playZone.order == undefined}
                            value={playZone.order}
                            onChange={newValue => {
                                editZone("order", newValue, index)
                            }}
                        />
                        <Button isLink className="attention-delete"
                                onClick={() => deletePlayZone(index)}>
                            Delete
                        </Button>
                    </Flex>
                </div>
                <FlexItem>
                    <div className={"mediaColumn"}>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={ media => {
                                editZoneMedia(media, index)
                            }}
                            title={ __( 'Zone Image', 'game-block' ) }
                            allowedTypes={ ALLOWED_MEDIA_TYPES }
                            multiple={ false }
                            value={ playZone.imageID }
                            render={ ( { open } ) => (
                                <>
                                    <Button className="button" onClick={ open }>Open Media Library</Button>
                                    <AttachmentImage imageId={playZone.imageID} />
                                    {
                                       /* playZone.imageURL && (
                                            <img
                                                src={ playZone.imageURL }
                                                alt={ __( 'Zone Image', 'game-block' ) }
                                                style={{
                                                    display: 'block',
                                                    maxWidth: '150px',
                                                    height: 'auto',
                                                }}
                                            />
                                        )*/
                                    }
                                </>

                            ) }
                        />
                    </MediaUploadCheck>
                    <Button className={(playZone.imageID === "") ? "hide" : "button show"} onClick={() => removeImage(index)}>Remove Image</Button>
                    </div>
                </FlexItem>
            </Flex>
        </>
    )
}