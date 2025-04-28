import PropTypes from 'prop-types';

export function IconDisplay({ iconPath, type }) {
    const siteUrl = window?.my_data?.siteUrl;

    if (!iconPath || !siteUrl) {
        return <div>Icon not set</div>;
    }

    const imageURL = `${siteUrl}${iconPath}.svg`;
    const imageURLOpen = `${siteUrl}${iconPath}-open.svg`;

    return (
        <div className="icon-display">
            <img
                src={imageURL}
                alt={type === "puzzle" ? "Puzzle icon (closed)" : "Icon"}
                className="icon-image"
            />
            {type === "puzzle" && (
                <>
                    &nbsp;
                    <img
                        src={imageURLOpen}
                        alt="Puzzle icon (open)"
                        className="icon-image-open"
                    />
                </>
            )}
        </div>
    );
}

// Optional: prop types to catch errors early
IconDisplay.propTypes = {
    iconPath: PropTypes.string,
    type: PropTypes.string,
};

// Optional: default props
IconDisplay.defaultProps = {
    iconPath: '',
    type: '',
};