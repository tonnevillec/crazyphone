import React, {useState, useEffect} from "react";
import {createRoot} from "react-dom/client";
import ShopLoader from "../components/ShopLoader";
import ProductCard from "./ProductCard";
import fetchApi from "../services/fetchApi";
import SelectOption from "../components/SelectOption";

const Shop = () => {
    const [datas, setDatas] = useState([]);
    const [filteredDatas, setFilteredDatas] = useState([]);
    const [search, setSearch] = useState({name: '', category: '', brand: ''});
    const [loading, setLoading] = useState(true);
    const [affCard, setAffCard] = useState(true)

    useEffect(() => {
        fetchDatas()
    }, [])

    useEffect(() => {
        setFilteredDatas(datas.filter(
            r =>
                r.name.toString().toLowerCase().includes(search.name.toLowerCase())
                &&
                r.category.title.toString().toLowerCase().includes(search.category.toLowerCase())
                &&
                r.brand.name.toString().toLowerCase().includes(search.brand.toLowerCase())
        ))
    }, [search])

    const fetchDatas= async () => {
        const products = await fetchApi.getProducts();
        setDatas(products);
        setFilteredDatas(products);

        setLoading(false);
    }

    const handleChange = (e) => {
        const currentTarget = e.currentTarget
        const {name, value} = currentTarget
        setSearch({...search, [name] : value})
    }

    const handleChangeAff = () => {
        setAffCard(!affCard)
    }

    const handleReset = () => {
        setFilteredDatas(datas)
        setSearch({name: '', category: '', brand: ''})
    }

    return <div className="flex flex-col md:flex-row gap-6">
            <div className="mb-2 md:basis-1/4">
                <div className="form-control w-full">
                    <label className="label" htmlFor="f_search">
                        <span className="label-text">Recherche</span>
                    </label>
                    <input type="text"
                           id="f_search"
                           name="name"
                           onChange={handleChange}
                           value={search.name}
                           placeholder="Recherche par mot-clé"
                           className="input input-bordered input-sm w-full"/>
                </div>

                <SelectOption
                    id={'f_category'}
                    name={'category'}
                    label={'Catégorie'}
                    handleChange={handleChange}
                    selectedValue={search.category}
                    endpoint={'categories'}
                ></SelectOption>

                <SelectOption
                    id={'f_brand'}
                    name={'brand'}
                    label={'Marque'}
                    handleChange={handleChange}
                    selectedValue={search.brand}
                    endpoint={'brands'}
                ></SelectOption>

                <button className="btn btn-ghost btn-xs mt-3" onClick={handleReset}>Réinitialiser</button>
            </div>

            <div className="md:basis-3/4">
                <div className="shop-aff w-full">
                    <div className="mb-7 w-full">
                        <div className="text-end mb-2">
                            <button className="btn btn-primary btn-sm" onClick={handleChangeAff}>
                                <i className="fa-solid fa-list"></i>
                            </button>
                        </div>
                        <div className="border-b border-slate-300 w-full"></div>
                    </div>

                    <div
                        className={affCard ? "grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-4 gap-6 place-items-stretch" : "flex flex-col gap-6"}>
                        {loading && <ShopLoader/>}
                        {!loading && <>
                            {filteredDatas.length === 0 && <p>No products</p>}
                            {filteredDatas.length > 0 && filteredDatas.map(product =>
                                <ProductCard key={product.id} product={product} affCard={affCard} />
                            )}
                        </>}
                    </div>
                </div>
            </div>
        </div>
    ;
}

class ShopElement extends HTMLElement {
    connectedCallback () {
        const root = createRoot(this);
        root.render(<Shop />);
    }
}

customElements.define('react-shop', ShopElement);