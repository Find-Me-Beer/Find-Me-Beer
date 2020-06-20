import React, {useState, useEffect} from "react"
import {Link} from "react-router-dom";

import Button from "react-bootstrap/Button";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import FormControl from "react-bootstrap/FormControl";
import InputGroup from "react-bootstrap/InputGroup";
import CardColumns from "react-bootstrap/CardColumns";

import {getEverythingButFavorites} from "../../shared/actions/get-beer";
import {BeerCard} from "./BeerCard";

import {useDispatch, useSelector} from "react-redux";
import {
	getAllFavorites,
	getFavoriteByFavoriteBeerIdAndFavoriteUserId,
	getFavoriteByFavoriteUserId
} from "../../shared/actions/get-favorite";
import {getAllTags, getTagByTagId} from "../../shared/actions/get-tag";
import {getBeerTagsByBeerTagBeerId, getBeerTagsByBeerTagTagId} from "../../shared/actions/get-beerTag";

export const Beer = () => {

	const dispatch = useDispatch();


	const effects = () => {
		dispatch(getEverythingButFavorites());
		dispatch(getAllFavorites());
		//dispatch(getBeerByTagId());
		// dispatch(getFavoriteByFavoriteBeerIdAndFavoriteUserId());
		// dispatch(getFavoriteByFavoriteUserId());
		//dispatch(getTagByTagId());
		// dispatch(getBeerTagsByBeerTagTagId());
		// dispatch(getBeerTagsByBeerTagBeerId())
	};

	const inputs = [];

	useEffect(effects, inputs);

	const beer = useSelector(state => {

		return state.beer ? state.beer : []});

	return (

		<>
			<main>
				<Container className="search-container p-3" fluid={true}>
					<Row>
						<Col md={7} className>
						</Col>
						<Col md={4} className>
							<InputGroup className="mb-3">
								<FormControl
									placeholder="search for beer"
									aria-label="search for beer"
									aria-describedby="basic-addon2"
								/>
								<InputGroup.Append>
									<Button variant="outline-info" className="search-button">Find Me Beer!</Button>
								</InputGroup.Append>
							</InputGroup>
						</Col>
					</Row>
				</Container>
				<Container fluid={true} className="py-4 beer-container">
					<Row className="mb-4">
						<Col>
							<h1 className={"text-center found-beer-title"}>We Found You Beer!</h1>
						</Col>
					</Row>
					<CardColumns>
						{beer.map(beer => <BeerCard beer={beer} key={beer.beerId}/>)}
					</CardColumns>
				</Container>
			</main>
		</>
	)
};