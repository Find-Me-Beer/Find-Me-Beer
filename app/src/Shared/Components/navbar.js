import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";
import divWithClassName from "react-bootstrap/cjs/divWithClassName";

const NavBar = () => {
	return (
		<>
			<header>
				<NavBar bg="dark" fixed="top">
					<Link to="/">
						<Navbar.Brand>Navbar</Navbar.Brand>
				</Link>

				<Navbar.Toggle aria-controls="basic-navbar-nav"></Navbar.Toggle>
				<Narbar.Collapse>

				<NavDropdown className="nav-link" title={"Preferences, Favorites, Profile"}>
					<NavDropdown.Item href="/preference">


