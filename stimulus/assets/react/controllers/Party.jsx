import React, { useEffect, useState } from 'react';
import Confetti from 'react-confetti';

const Party = ({ confettis = 500, duration = 5000 }) => {
    const [screenDimensions, setScreenDimensions] = useState([window.innerWidth, window.innerHeight]);

    useEffect(() => {
        setScreenDimensions(window.innerWidth, window.innerHeight);
    }, [window.innerWidth, window.innerWidth]);

    return <Confetti
        width={screenDimensions[0]}
        height={screenDimensions[1]}
        recycle={false}
        numberOfPieces={confettis}
        tweenDuration={duration}
    />;
};

export default Party;
