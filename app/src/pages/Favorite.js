import React, {useState, useEffect} from "react";
import {useSelector} from "react-redux";
import {httpConfig} from "../shared/misc/http-config";
import {UseJwt} from "../shared/misc/JwtHelpers";
import {handleSessionTimeout} from "../shared/misc/handle-session-timeout";
import _ from "lodash";

import Button from "react-bootstrap/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";

//Based on Example from Rochelle Lewis

export const Favorite = ({favoriteBeerId, favoriteUserId}) => {

	// grab the jwt for logged in users
	const jwt = UseJwt();
	const [isFavorited, setIsFavorited] = useState(null);

	// Grab all favorites from the redux store
	const favorites = useSelector(state => (state.favorites ? state.favorites : []));

	const effects = () => {
		initializeFavorites(userId);
	};

	// add favorites to inputs - this informs React that favorites are being updated from Redux. This ensures proper component rendering.
	const inputs = [favorites, userId, beerId];
	useEffect(effects, inputs);

	const initializeFavorites = (userId) => {
		const userFavorites = favorites.filter(favorite => favorite.favoriteUserId === userId);
		const favorited = _.find(userFavorites, {'favoriteBeerId': beerId});
		return (_.isEmpty(favorited) === false) && setIsFavorited("active");
	};

	/*
	* data object gets passed in Axios POST and DELETE requests.
	* See submitFavorite and deleteFavorite below.
	* */
	const data = {
		favoriteBeerId: beerId,
		favoriteUserId: userId
	};

	/*
	* toggleFavorite gets called when a Favorite is successfully created or deleted by the user.
	* This toggles the state of the isFavorited variable.
	*
	* See submitFavorite and deleteFavorite.
	* */
	const toggleFavorite = () => {
		setIsFavorited(isFavorited === null ? "active" : null);
	};

	/*
	* User posts a Favorite.
	* */
	const submitFavorite = () => {
		const headers = {'X-JWT-TOKEN': jwt};
		httpConfig.post("/apis/favorite/", data, {
			headers: headers})
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					toggleFavorite();
				}
				// if there's an issue with a $_SESSION mismatch with xsrf or jwt, alert user and do a sign out
				if(reply.status === 401) {
					handleSessionTimeout();
				}
			});
	};

	/*
* User deletes a Favorite.
* */
	const deleteFavorite = () => {
		const headers = {'X-JWT-TOKEN': jwt};
		httpConfig.delete("/apis/favorite/", {
			headers, data})
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					toggleFavorite();
				}
				// if there's an issue with a $_SESSION mismatch with xsrf or jwt, alert user and do a sign out
				if(reply.status === 401) {
					handleSessionTimeout();
				}
			});
	};

	/*
	* Fire this function onclick
	* */
	const clickFavorite = () => {
		(isFavorited === "active") ? deleteFavorite() : submitFavorite();
	};

	return (
		<>
			<Button variant="outline-danger" size="sm" className={`post-favorite-btn ${(isFavorited !== null ? isFavorited : "")}`} disabled={!jwt && true} onClick={clickFavorite}>
				<FontAwesomeIcon icon="star"/>&nbsp;
			</Button>
		</>
	)
};