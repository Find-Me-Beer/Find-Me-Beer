import React from 'react';
import {useSelector} from "react-redux";

export const BeerBreweryName = ({breweryId}) => {

	const brewery = useSelector((state) => {
		return state.brewery ? state.brewery.find(brewery => breweryId === brewery.breweryId) : null
	});

	return (
		<>
			{brewery ? brewery.breweryName : "???"}
		</>
	);

};