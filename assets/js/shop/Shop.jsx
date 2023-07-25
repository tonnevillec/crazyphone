import React, {useState, useEffect} from "react";
import {createRoot} from "react-dom/client";
import ShopLoader from "../components/ShopLoader";
import ProductCard from "./ProductCard";
import fetchApi from "../services/fetchApi";

const Shop = () => {
    const [datas, setDatas] = useState([]);
    const [filteredDatas, setFilteredDatas] = useState([]);
    const [search, setSearch] = useState({name: '', category: '', brand: ''});
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchDatas()
    }, [])

    const fetchDatas= async () => {
        const products = await fetchApi.getProducts();
        setDatas(products);
        setFilteredDatas(products);

        setLoading(false);
    }

    const handleChange = ({currentTarget}) => {
        const {name, value} = currentTarget
        setSearch({...search, [name] : value})
console.log(search)
        setFilteredDatas(datas.filter(
            r =>
                r.name.toString().toLowerCase().includes(search.name.toLowerCase())
                &&
                r.category.title.toString().toLowerCase().includes(search.category.toLowerCase())
        ))
    }

    const handleSearch = ({currentTarget}) => {
        console.log(currentTarget.name)
        const {name, value} = currentTarget
        setSearch({...search, [name] : value})
        // setSearch(currentTarget.value)
        // setFilteredDatas(datas.filter(
        //     r => r.name.toString().toLowerCase().includes(currentTarget.value.toLowerCase())
        // ))
    }

    const handleSearchCategory = ({currentTarget}) => {
        setSearchCategory(currentTarget.value)
        setFilteredDatas(datas.filter(
            r => r.category.title.toString().toLowerCase().includes(currentTarget.value.toLowerCase())
        ))
    }

    return <>
        <div className="flex flex-col md:flex-row gap-6">
            <div className="mb-2 md:basis-1/4">
                <h2>Filtre</h2>

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

                <div className="form-control w-full">
                    <label className="label" htmlFor="f_search2">
                        <span className="label-text">Catégorie</span>
                    </label>
                    <input type="text"
                           id="f_search2"
                           name="category"
                           onChange={handleChange}
                           value={search.category}
                           placeholder="Recherche par mot-clé"
                           className="input input-bordered input-sm w-full"/>
                </div>
            </div>

            <div className="md:basis-3/4">
                <div className="shop-aff w-full">
                    <div className="mb-7 w-full">
                        <div className="text-end mb-2">
                            <button className="btn btn-primary btn-sm">
                                <i className="fa-solid fa-list"></i>
                            </button>
                        </div>
                        <div className="border-b border-slate-300 w-full"></div>
                    </div>

                    <div
                        className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-4 gap-6 place-items-stretch">
                        {loading && <ShopLoader/>}
                        {!loading && <>
                            {filteredDatas.length === 0 && <p>No products</p>}
                            {filteredDatas.length > 0 && filteredDatas.map(product =>
                                <ProductCard key={product.id} product={product} />
                            )}
                        </>}
                    </div>
                </div>
            </div>
        </div>
    </>;
}

class ShopElement extends HTMLElement {
    connectedCallback () {
        const root = createRoot(this);
        root.render(<Shop />);
    }
}

customElements.define('react-shop', ShopElement);