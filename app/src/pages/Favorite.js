import React, {useState, useEffect} from "react";
import {useSelector} from "react-redux";
import {httpConfig} from "../shared/misc/http-config";
import {UseJwt} from "../shared/misc/JwtHelpers";
import {handleSessionTimeout} from "../shared/misc/handle-session-timeout";
import _ from "lodash";

import Badge from "react-bootstrap/Badge";
import Button from "react-bootstrap/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";

export const Favorite = ({favoriteBeerId, favoriteUserId}) => {

	// grab the jwt for logged in users
	const jwt = UseJwt();
	const [isFavorited, setIsFavorited] = useState(null);

	// Grab all likes from the redux store
	const likes = useSelector(state => (state.favorites ? state.favorite : []));

	const effects = () => {
		initializeFavorites(userId);
	};

	// add likes to inputs - this informs React that likes are being updated from Redux. This ensures proper component rendering.
	const inputs = [favorites, userId, beerId];
	useEffect(effects, inputs);

	const initializeFavorites = (userId) => {
		const userFavorites = favorites.filter(favorite => favorite.favoriteUserId === userId);
		const favorited = _.find(userLikes, {'favoriteBeerId': beerId});
		return (_.isEmpty(favorited) === false) && setIsLiked("active");
	};

	const data = {
		favoriteBeerId: beerId,
		favoriteUserId: userId
	};












}