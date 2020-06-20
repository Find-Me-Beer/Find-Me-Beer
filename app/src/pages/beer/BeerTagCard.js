import React from 'react'
import { useSelector } from 'react-redux'
import Card from "react-bootstrap/Card";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import {Favorite} from "../Favorite";
import {TagCard} from "./TagCard";

export const BeerTagCard = ({ beerTag }) => {
	const tags = useSelector((state) => state.tags ? state.tags : null);
	const FindTagContent = () => {
		const foundTags = tags.filter(tag => {let result = beerTag.beerTagTagId === tag.tagId;

			return result
		}) ;
		return (
			<>
				{foundTags.map(tag => <TagCard tag={tag} key={tag.tagId}/>)}
			</>
		)
	};
	return (
		<>
			<FindTagContent/>
		</>
	)
};