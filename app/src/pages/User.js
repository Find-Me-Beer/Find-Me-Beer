
import React, {useEffect} from "react";
import {useSelector, useDispatch} from "react-redux";
import {UseJwtUserId} from "../shared/misc/JwtHelpers";

import {getUserByUserId} from "../shared/actions/get-user";


export const User = ({match}) => {

	// grab the profile id from the JWT for the currently logged in account
	const currentUserId = UseJwtUserId();

	// Return all profiles from the redux store
	const users = useSelector(state => (state.user ? state.user : []));

	// Grab the profile off of the profiles object that matches the profileId from the URL.
	const user = users.find(function (o) {return o.userId === match.params.userId});
	console.log(user); //check it!

	const dispatch = useDispatch();

	const effects = () => {
		dispatch(getUserByUserId());
	};

	const inputs = [];
	useEffect(effects, inputs);

};

