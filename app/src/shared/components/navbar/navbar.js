import React, {useEffect} from "react";
import {httpConfig} from "../../misc/http-config";
import {Link} from "react-router-dom";
import {UseJwt, UseJwtUserId, UseJwtUsername} from "../../misc/JwtHelpers";

import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import NavDropdown from "react-bootstrap/NavDropdown";
import Button from "react-bootstrap/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {SignUpModal} from "../../../pages/signup/SignUpModal";
import {SignInModal} from "../sign-in/SigninModal";
export const NavBar = () => {

	// grab the jwt and username for logged in users
	const jwt = UseJwt();
	
	useEffect( () =>{
		httpConfig.get("/apis/xsrf/")
	});

	const signOut = () => {
		httpConfig.get("apis/sign-out/")
			.then(reply => {
				if (reply.status === 200) {
					window.localStorage.removeItem("jwt-token");
					console.log(reply);
					setTimeout(() => {
						window.location.reload();
					}, 1500);
				}
			});
	};

	return(
		<Navbar className="nav-style fixed-top"
				  expand="lg"
				  variant="dark"
		>

			{/*<LinkContainer exact to="/">*/}
			{/*	<img alt="ABQCOOKBOOK Icon"*/}
			{/*		  src= {logo}*/}
			{/*		  id="nav-image"*/}
			{/*		  className="d-none d-lg-inline-block align-top"*/}
			{/*	/>*/}
			{/*</LinkContainer>*/}

			{/*<LinkContainer exact to="/">*/}
			{/*	<img alt="ABQCOOKBOOK Icon"*/}
			{/*		  src={smallLogo}*/}
			{/*		  id="nav-image-small"*/}
			{/*		  className="d-lg-none d-inline-block align-top"*/}
			{/*	/>*/}
			{/*</LinkContainer>*/}

			<Navbar.Toggle aria-controls="responsive-navbar-nav" />
			<Navbar.Collapse id="responsive-navbar-nav">
				<Nav className="ml-auto text-right">

					{/*<Nav.Link href="/recipe-list"*/}
					{/*			 className="py-3 mr-1 d-lg-none d-inline-block"*/}
					{/*>SEARCH</Nav.Link>*/}
					{/*{jwt !== null ?*/}
					{/*	<UserMenu/>*/}
					{/*	:*/}
					{/*	<SignInModal/>*/}
					{/*}*/}

					{/*{jwt !== null &&*/}
					{/*<Nav.Link className="py-4 d-lg-none d-block"*/}
					{/*			 id="menuSignOut"*/}
					{/*			 href="/recipe-submission"*/}
					{/*>*/}
					{/*	CREATE RECIPE*/}
					{/*</Nav.Link>*/}
					{/*}*/}

					{/*{jwt !== null &&*/}
					{/*<Nav.Item className="py-4"*/}
					{/*			 id="menuSignOut">MY RECIPES</Nav.Item>*/}
					{/*}*/}

					{/*{jwt !== null &&*/}
					{/*<Nav.Item className="py-4"*/}
					{/*			 id="menuSignOut">ACCOUNT SETTINGS</Nav.Item>*/}
					{/*}*/}

					{/*{jwt !== null ?*/}
					{/*	<Nav.Item onClick={signOut}*/}
					{/*				 className="py-4"*/}
					{/*				 id="menuSignOut"*/}
					{/*	>SIGN OUT</Nav.Item>*/}
					{/*	:*/}
					{/*	<SignUpModal/>*/}
					{/*}*/}
				</Nav>
			</Navbar.Collapse>
		</Navbar>
	)
};