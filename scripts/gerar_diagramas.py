"""Generate small, self-contained teaching diagrams for the six lessons."""

from pathlib import Path

from PIL import Image, ImageDraw, ImageFont


ROOT = Path(__file__).resolve().parents[1]
OUTPUT = ROOT / "View" / "img"
WIDTH, HEIGHT = 760, 260
NAVY = "#123554"
TEAL = "#0f766e"
PALE = "#e9f4f3"
LIGHT = "#f7fafc"
MUTED = "#526779"
LINE = "#b9ccd3"
RED = "#b42318"
FONT_DIR = Path("C:/Windows/Fonts")
REGULAR = FONT_DIR / "segoeui.ttf"
BOLD = FONT_DIR / "segoeuib.ttf"


def font(size, bold=False):
    return ImageFont.truetype(str(BOLD if bold else REGULAR), size)


def centered(draw, x, y, label, size=24, color=NAVY, bold=True):
    draw.text((x, y), label, font=font(size, bold), fill=color, anchor="mm")


def canvas(title, stage, note):
    image = Image.new("RGB", (WIDTH, HEIGHT), "white")
    draw = ImageDraw.Draw(image)
    draw.rectangle((0, 0, WIDTH, 5), fill=TEAL)
    draw.text((28, 23), title, font=font(20, True), fill=NAVY)
    draw.text((WIDTH - 28, 25), stage, font=font(16, True), fill=TEAL, anchor="ra")
    draw.line((28, 57, WIDTH - 28, 57), fill=LINE, width=1)
    draw.line((28, 216, WIDTH - 28, 216), fill=LINE, width=1)
    draw.text((28, 231), note, font=font(17), fill=MUTED)
    return image, draw


def box(draw, xy, label, highlight=False, faded=False, size=29):
    fill = PALE if highlight else (LIGHT if faded else "white")
    outline = TEAL if highlight else LINE
    draw.rounded_rectangle(xy, radius=7, fill=fill, outline=outline, width=3 if highlight else 2)
    centered(draw, (xy[0] + xy[2]) / 2, (xy[1] + xy[3]) / 2, label, size, TEAL if highlight else NAVY)


def arrow(draw, start, end, color=TEAL, width=3):
    draw.line((start, end), fill=color, width=width)
    x1, y1 = start
    x2, y2 = end
    if abs(x2 - x1) > abs(y2 - y1):
        direction = 1 if x2 > x1 else -1
        head = [(x2, y2), (x2 - 11 * direction, y2 - 6), (x2 - 11 * direction, y2 + 6)]
    else:
        direction = 1 if y2 > y1 else -1
        head = [(x2, y2), (x2 - 6, y2 - 11 * direction), (x2 + 6, y2 - 11 * direction)]
    draw.polygon(head, fill=color)


def row(draw, labels, positions, active=(), double=False):
    top, bottom, width = 104, 168, 104
    for index, (label, x) in enumerate(zip(labels, positions)):
        box(draw, (x, top, x + width, bottom), label, highlight=index in active)
        if index:
            previous = positions[index - 1] + width
            if double:
                arrow(draw, (previous + 6, 128), (x - 6, 128))
                arrow(draw, (x - 6, 146), (previous + 6, 146), color=NAVY)
            else:
                arrow(draw, (previous + 8, 136), (x - 8, 136))


def tad(stage):
    descriptions = ["Vetor implementa o contrato", "Nós implementam o mesmo contrato"]
    image, draw = canvas("TAD: CONTRATO", f"ETAPA {stage + 1} / 2", descriptions[stage])
    box(draw, (38, 82, 326, 195), "CONTRATO", highlight=True, size=27)
    centered(draw, 182, 167, "Inserir()  ·  Remover()", 19, NAVY, False)
    arrow(draw, (343, 138), (412, 138))
    box(draw, (430, 82, 722, 195), "VETOR" if stage == 0 else "NÓS", size=30)
    return image


def simples(stage):
    notes = ["Lista antes da inserção", "Novo nó aponta para o início antigo", "Início aponta para o novo nó"]
    image, draw = canvas("LISTA SIMPLES: INSERIR NO INÍCIO", f"ETAPA {stage + 1} / 3", notes[stage])
    if stage == 0:
        row(draw, ["A", "B", "C"], [132, 328, 524], active=(0,))
        centered(draw, 184, 83, "INÍCIO", 17, TEAL)
    else:
        row(draw, ["X", "A", "B", "C"], [32, 226, 420, 614], active=(0,))
        centered(draw, 278 if stage == 1 else 84, 83, "INÍCIO", 17, TEAL)
    return image


def dupla(stage):
    notes = ["A, B e C ligados nos dois sentidos", "B é removido", "A e C são religados nos dois sentidos"]
    image, draw = canvas("LISTA DUPLA: REMOVER UM NÓ", f"ETAPA {stage + 1} / 3", notes[stage])
    if stage < 2:
        row(draw, ["A", "B", "C"], [85, 330, 575], active=(1,) if stage == 1 else (), double=True)
        if stage == 1:
            draw.line((341, 112, 423, 160), fill=RED, width=4)
            draw.line((423, 112, 341, 160), fill=RED, width=4)
    else:
        row(draw, ["A", "C"], [200, 455], active=(0, 1), double=True)
    return image


def fila(stage):
    notes = ["A chegou primeiro", "D entra no fim", "A sai pelo início; B passa à frente"]
    image, draw = canvas("FILA FIFO: ENTRADA E SAÍDA", f"ETAPA {stage + 1} / 3", notes[stage])
    if stage == 0:
        labels, positions, active = ["A", "B", "C"], [132, 328, 524], (0,)
    elif stage == 1:
        labels, positions, active = ["A", "B", "C", "D"], [32, 226, 420, 614], (3,)
    else:
        labels, positions, active = ["B", "C", "D"], [132, 328, 524], (0,)
    row(draw, labels, positions, active)
    centered(draw, positions[0] + 52, 83, "INÍCIO", 17, TEAL)
    centered(draw, positions[-1] + 52, 188, "FIM", 17, TEAL)
    return image


def prioridade(stage):
    notes = ["Ordem atual: 5, 3, 2", "Chega D com prioridade 6", "D ocupa o início da fila"]
    image, draw = canvas("FILA DE PRIORIDADES: INSERÇÃO", f"ETAPA {stage + 1} / 3", notes[stage])
    if stage == 0:
        row(draw, ["B: 5", "C: 3", "A: 2"], [132, 328, 524], active=(0,))
    elif stage == 1:
        row(draw, ["B: 5", "C: 3", "A: 2"], [226, 420, 614])
        box(draw, (32, 104, 136, 168), "D: 6", highlight=True, size=26)
    else:
        row(draw, ["D: 6", "B: 5", "C: 3", "A: 2"], [32, 226, 420, 614], active=(0,))
    return image


def pilha(stage):
    notes = ["C está no topo", "PUSH coloca D no topo", "POP retira D; C volta ao topo"]
    image, draw = canvas("PILHA LIFO: PUSH E POP", f"ETAPA {stage + 1} / 3", notes[stage])
    labels = ["C", "B", "A"] if stage != 1 else ["D", "C", "B", "A"]
    top = 78 if stage != 1 else 67
    height = 37 if stage != 1 else 33
    gap = 4
    for index, label in enumerate(labels):
        y = top + index * (height + gap)
        box(draw, (317, y, 444, y + height), label, highlight=index == 0, size=23)
    centered(draw, 205, top + height / 2, "TOPO", 19, TEAL)
    arrow(draw, (252, top + height / 2), (302, top + height / 2))
    return image


DIAGRAMS = {
    "tad-contrato": tad,
    "lista-simples-insercao": simples,
    "lista-dupla-remocao": dupla,
    "fila-fifo": fila,
    "fila-prioridade": prioridade,
    "pilha-lifo": pilha,
}


def main():
    OUTPUT.mkdir(parents=True, exist_ok=True)
    for name, render in DIAGRAMS.items():
        frames = [render(i) for i in range(2 if name == "tad-contrato" else 3)]
        frames[-1].save(OUTPUT / f"{name}.png", optimize=True)
        frames[0].save(
            OUTPUT / f"{name}.gif",
            save_all=True,
            append_images=frames[1:],
            duration=[1500] * (len(frames) - 1) + [2200],
            loop=0,
            optimize=True,
            disposal=2,
        )
        print(name)


if __name__ == "__main__":
    main()
