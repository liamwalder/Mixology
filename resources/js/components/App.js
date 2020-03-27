import React, { Component } from 'react';
import ReactDOM from "react-dom";
import Ingredients from "./Ingredients";
import Drinks from "./Drinks";
import classNames from "classnames";

class App extends Component {

    constructor(props) {
        super(props);

        this.selectIngredient = this.selectIngredient.bind(this);
        this.clearSelectedIngredients = this.clearSelectedIngredients.bind(this);

        this.state = {
            splash: true,
            showDrinks: false,
            selectedIngredients: []
        };
    }

    // Managing selected ingredients. If it already exists remove it, if it doesn't, add to array.
    selectIngredient(ingredientId) {
        let selectedIngredients;

        let selectedIngredientExists = this.state.selectedIngredients.some(selectedIngredientId => selectedIngredientId === ingredientId);

        if (selectedIngredientExists) {
            selectedIngredients = this.state.selectedIngredients.filter(selectedIngredient => selectedIngredient !== ingredientId);
        } else {
            selectedIngredients = this.state.selectedIngredients.slice(0);
            selectedIngredients.push(ingredientId);
        }

        this.setState({ selectedIngredients: selectedIngredients });
    }

    componentDidUpdate() {
        this.render();
    }

    // Clear selected ingredients.
    clearSelectedIngredients() {
        this.setState({ selectedIngredients: [] });
    }

    // Show drinks, this is only used on small screens.
    showDrinks() {
        this.setState({ showDrinks: true });
    }

    // Show ingredients, this is only used on small screens.
    showIngredients() {
        this.setState({ showDrinks: false });
    }

    // Hide splash.
    hideSplash() {
        this.setState({ splash: false });
    }

    // Render
    render() {

        // Classes to add to drinks list.
        let drinkListClass = classNames (
            'block',
            'lg:block',
            'xl:block',
            'md:block',
            'md:w-6/12',
            'lg:w-8/12',
            'md:border',
            'md:border-l-4',
            'md:border-solid',
            'bg-grey-background',
            'border-grey-background',
            {
                'hidden': this.state.showDrinks === false
            }
        );

        // Classes to add to ingredients list.
        let ingredientsListClass = classNames (
            'w-full',
            'md:w-6/12',
            'lg:w-4/12',
            'xl:w-4/12',
            {
                'hidden': this.state.showDrinks === true
            }
        );

        // If we have at least one selected ingredient, we can show the "MIX" button mobile
        let mixButton;
        if (this.state.selectedIngredients.length > 0) {
            mixButton = <span onClick={ this.showDrinks.bind(this) } className="md:hidden lg:hidden xl:hidden text-peach py-2 px-2 font-black text-sm rounded-full bg-white cursor-pointer">MIX</span>
        }

        // Display the splash page initially until they have click the button.
        let content;
        if (this.state.splash === true) {

            content =
                <div className="bg-peach h-screen w-screen flex items-center justify-center flex-col">
                    <h1 className="text-5xl md:text-6xl font-black text-white tracking-widest">MIXOLOGY</h1>
                    <p className="mt-5 font-semibold text-white text-xl text-center">find mixed drink creations from ingredients you already own</p>
                    <button onClick={ this.hideSplash.bind(this) } className="focus:outline-none bg-white px-10 py-5 text-peach font-semibold mt-10 rounded-lg hover:font-black">browse, mix & enjoy</button>
                </div>

        } else {

            content =
                <div className="flex flex-row">
                    <div className={ingredientsListClass}>
                        <div>
                            <div className="px-10 py-5 bg-peach flex flex-row justify-between items-center">
                                <h1 className="font-black text-white tracking-widest">MIXOLOGY</h1>
                                {mixButton}
                            </div>
                            <p className="td mt-5 px-10 text-center font-semibold">Select at least on ingredient below to find your mixed creations.</p>
                            <div className="p-10 py-5">
                                <Ingredients
                                    selectIngredient={ this.selectIngredient }
                                    selectedIngredients={ this.state.selectedIngredients }
                                    clearSelectedIngredients={ this.clearSelectedIngredients }
                                />
                            </div>
                        </div>
                    </div>
                    <div className={drinkListClass}>
                        <div className="md:hidden lg:hidden xl:hidden px-10 py-5 bg-peach flex flex-row items-center">
                            <span onClick={ this.showIngredients.bind(this) } className="mr-5 md:hidden lg:hidden xl:hidden text-peach py-2 px-2 font-black text-sm rounded-full bg-white cursor-pointer">BACK</span>
                            <h1 className="font-black text-white tracking-widest">MIXOLOGY</h1>
                        </div>
                        <div className="py-5 px-10 h-screen overflow-scroll">
                            <div className="px-2">
                                <h1 className="font-bold">Drinks</h1>
                            </div>
                            <Drinks className="mt-10" selectedIngredients={ this.state.selectedIngredients } />
                        </div>
                    </div>
                </div>

        }

        return (
            <div>
                {content}
            </div>
        );
    }

}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}