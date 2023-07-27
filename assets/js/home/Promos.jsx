import {createRoot} from "react-dom/client";
import React, {useState} from "react";
// import Carousel from "nuka-carousel";
import AliceCarousel from "react-alice-carousel";

const Promos = () => {
    const items = [
        <img src="https://picsum.photos/1280/1024?random=1" className="item" data-value="1" alt="" role="presentation"/>,
        <img src="https://picsum.photos/1280/1024?random=2" className="item" data-value="2" alt="" role="presentation"/>,
        <img src="https://picsum.photos/1280/1024?random=3" className="item" data-value="3" alt="" role="presentation"/>
    ];

    // https://github.com/maxmarinich/react-alice-carousel

    return <div className={"max-h-[550px]"}>
        <AliceCarousel
            animationType="fadeout"
            animationDuration={800}
            disableButtonsControls
            infinite
            items={items}
            mouseTracking
            responsive={
            {
                0: {
                    items: 1,
                },
                1024: {
                    items: 2,
                    itemsFit: 'contain',
                },
            }}
        />
    </div>;
}

class PromosElement extends HTMLElement {
    connectedCallback () {
        const root = createRoot(this);
        root.render(<Promos />);
    }
}

customElements.define('react-promos', PromosElement);