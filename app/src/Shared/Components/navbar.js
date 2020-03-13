import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import divWithClassName from "react-bootstrap/cjs/divWithClassName";
import {Link} from "react-router-dom";

import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import NavDropdown from "react-bootstrap/NavDropdown";
import Button from "react-bootstrap/Button";


import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";


export const NavBar = () => {
	return (
		<>
			<header>
				<Navbar class="navbar" bg="primary" expand="md" variant="light" fixed="top">
					<Link to="/">
						<Navbar.Brand>Find Me Beer!</Navbar.Brand>
					</Link>
					<Navbar.Toggle aria-controls="basic-navbar-nav">Find Me Beer</Navbar.Toggle>
					<Navbar.Collapse>
						<Nav className="ml-auto">
							<NavDropdown className="nav-link" title={"Profile"}>
								<NavDropdown.Item href="/profile">
									<FontAwesomeIcon icon="Favorites"/>&nbsp; Favorites
									<FontAwesomeIcon icon="Profile"/>&nbsp; Profile
								</NavDropdown.Item>
								<div className="dropdown-divider"></div>
								<div className="dropdown-item log-out-dropdown">
									<button className="btn btn-outline-dark">
										Log Out&nbsp;<FontAwesomeIcon icon="log-out-alt"/>
									</button>
								</div>
							</NavDropdown>
						</Nav>
					</Navbar.Collapse>
				</Navbar>
			</header>
		</>
	)
};