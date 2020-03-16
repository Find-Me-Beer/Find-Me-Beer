import React, {useState, useEffect} from "react";
import * as jwtDecode from "jwt-decode";

/*
* Custom hooks to grab the jwt and decode jwt data for logged in users.
*
* Author: Vlad & rlewis37@cnm.edu
 */

export const UseJwt = () => {
	const [jwt, setJwt] = useState(null);

	useEffect(() => {
		setJwt(window.localStorage.getItem("jwt-token"));
	}, [jwt]);

	return jwt;
};

export const UseJwtUsername = () => {
	const [username, setUsername] = useState(null);

	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodedJwt = jwtDecode(token);
			setUsername(decodedJwt.auth.userUsername);
		}
	}, [username]);

	return username;
};

export const UseJwtUserId = () => {
	const [userId, setUserId] = useState(null);


	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodedJwt = jwtDecode(token);
			setUserId(decodedJwt.auth.userId);
		}
	}, [userId]);

	return userId;
};