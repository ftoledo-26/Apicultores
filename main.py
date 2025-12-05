import requests
import json
import time

# Categorías oficiales de OpenLibrary que queremos recorrer
CATEGORIAS = ["fiction", "history", "technology", "fantasy", "science", "children", "biography"]

# Categorías preexistentes en tu DB
CATEGORIAS_EXISTENTES = {"Ficción", "Historia", "Tecnología", "Fantasía"}

def descargar_todos_los_libros(out_file="libros_completo.json", limite=50):
    libros_totales = []
    categorias_nuevas = set()

    print("=== DESCARGA COMPLETA DE LIBROS POR CATEGORÍA ===\n")

    for categoria in CATEGORIAS:
        offset = 0
        pagina = 1
        print(f"\n=== Descargando categoría '{categoria}' ===\n")

        while True:
            print(f"Página {pagina} (offset={offset})...")

            url = f"https://openlibrary.org/subjects/{categoria}.json"
            params = {
                "limit": limite,
                "offset": offset
            }

            try:
                resp = requests.get(url, params=params, timeout=30)
                resp.raise_for_status()
            except Exception as e:
                print(f"Error al descargar página {pagina} de '{categoria}': {e}")
                break

            datos = resp.json()
            libros = datos.get("works", [])

            if not libros:
                print("No hay más libros en esta categoría.\n")
                break

            for doc in libros:
                titulo = doc.get("title", "Sin título")
                authors = doc.get("authors", [])
                autor = ", ".join([a.get("name", "") for a in authors]) if authors else None

                subjects = doc.get("subject", [])
                categoria_libro = subjects[0] if subjects else categoria.capitalize()

                if categoria_libro not in CATEGORIAS_EXISTENTES:
                    categorias_nuevas.add(categoria_libro)

                libros_totales.append({
                    "titulo": titulo,
                    "autor": autor,
                    "categoria": categoria_libro
                })

            # Preparar siguiente página
            if len(libros) < limite:
                print(f"Fin de la categoría '{categoria}'.\n")
                break

            offset += limite
            pagina += 1
            time.sleep(0.2)  # evitar saturar la API

    # Guardar JSON final
    with open(out_file, "w", encoding="utf-8") as f:
        json.dump(libros_totales, f, indent=4, ensure_ascii=False)

    print(f"\nArchivo '{out_file}' creado con {len(libros_totales)} libros.\n")

    # Mostrar INSERTS de nuevas categorías
    if categorias_nuevas:
        print("=== NUEVAS CATEGORÍAS DETECTADAS ===")
        for cat in categorias_nuevas:
            print(f"INSERT INTO categorias (nombre) VALUES ('{cat}');")
    else:
        print("No se detectaron categorías nuevas.")


if __name__ == "__main__":
    descargar_todos_los_libros()
