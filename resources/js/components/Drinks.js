import ReactDOM from 'react-dom';
import classNames from "classnames";
import React, { Component } from 'react';
import DrinkModal from "./DrinkModal";

const initialState = {
    drink: [],
    drinks: []
};

class Drinks extends Component {

    // Constructor
    constructor() {
        super();

        this.selectDrink = this.selectDrink.bind(this);

        this.state = initialState;
    }

    // Reset our component to it's initial state.
    resetState() {
        this.setState(initialState);
    }

    // Handle when the component has updated.
    componentDidUpdate(previousProps) {

        // If we don't have any selected ingredients, we reset to show no drinks.
        if (previousProps.selectedIngredients.length > 0 && this.props.selectedIngredients.length === 0) {
            this.resetState();
        }

        // If the selected ingredients have changed and we have at least 1, render our filtered drinks.
        if ((previousProps.selectedIngredients !== this.props.selectedIngredients) && this.props.selectedIngredients.length > 0) {
            fetch('/api/drinks/filtered', {
                method: 'POST',
                body: JSON.stringify({
                    ingredients: this.props.selectedIngredients,
                })
            })
            .then(results => {
                return results.json();
            }).then(data => {
                this.setDrinkItems(data.data);
            });

        }

    }

    // Set selected drink
    selectDrink(drink) {
        this.setState({ drink: drink });
    }

    // Set drinks list.
    setDrinkItems(drinksList) {
        let drinks = drinksList.map((drink) => {
            return (
                <div className="md:w-full lg:w-4/12 xl:w-3/12 flex" key={ drink.id }>
                    <div className="m-2 bg-white rounded-lg flex-grow flex-grow-0 cursor-pointer" onClick={ this.selectDrink.bind(this, drink) }>
                        <img className="w-full bg-white rounded-lg" src={ drink.thumbnail.url } alt={ drink.name.toLowerCase() } />
                        <div className="px-2 py-2 bg-white rounded-lg">
                            <div className="font-bold text-sm mb-1">{ drink.name.toLowerCase() }</div>
                            <div className="flex flex-col">
                                {drink.ingredients.data.map((drinkIngredient, index) => {

                                    let ingredientItemClasses = classNames (
                                        'text-xs',
                                        'font-bold',
                                        {
                                            'text-grey-background': !this.props.selectedIngredients.some(selectedIngredient => (
                                                selectedIngredient === drinkIngredient.ingredient.id
                                            )),
                                            'text-peach': this.props.selectedIngredients.some(selectedIngredient => (
                                                selectedIngredient === drinkIngredient.ingredient.id
                                            ))
                                        }
                                    );

                                    return <span key={ drinkIngredient.id } className={ingredientItemClasses}>
                                                { drinkIngredient.ingredient.name.toLowerCase() }
                                            </span>
                                })}
                            </div>
                        </div>
                    </div>
                </div>
            )
        });

        this.setState({ drinks: drinks });
    }

    // Render
    render() {

        if (this.state.drinks.length === 0) {
            return (
                <div className="flex flex-col items-center justify-center h-screen">
                    <p className="font-black text-xl text-white tracking-widest">NO RESULTS</p>
                </div>
            );
        }

        return (
            <div>
                <DrinkModal drink={ this.state.drink } selectDrink={ this.selectDrink } selectedIngredients={ this.props.selectedIngredients } />
                <div className="overflow-scroll flex flex-row flex-wrap">
                    { this.state.drinks }
                </div>
            </div>
        );
    }

}

export default Drinks;

if (document.getElementById('drinks')) {
    ReactDOM.render(<Drinks />, document.getElementById('drinks'));
}